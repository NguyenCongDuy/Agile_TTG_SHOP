<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();

            // Xóa các đơn hàng và thanh toán liên quan
            foreach ($user->orders as $order) {
                $order->orderDetails()->delete();
                if ($order->payment) {
                    $order->payment->delete();
                }
                $order->delete();
            }

            // Xóa avatar nếu có
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            // Đăng xuất người dùng
            Auth::guard('web')->logout();

            // Xóa tài khoản
            $user->delete();

            // Xóa session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            DB::commit();

            return redirect()->route('client.home')
                ->with('success', 'Tài khoản của bạn đã được xóa thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['userDeletion' => 'Có lỗi xảy ra khi xóa tài khoản.'])
                ->withInput();
        }
    }
}

