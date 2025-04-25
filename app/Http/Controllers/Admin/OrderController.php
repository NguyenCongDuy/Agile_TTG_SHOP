<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function dashboard()
    {
        // Get order statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        // Get revenue statistics
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $paidRevenue = Order::whereHas('payment', function($query) {
            $query->where('status', 'paid');
        })->sum('total_amount');

        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.orders.dashboard', compact(
            'totalOrders', 'pendingOrders', 'processingOrders', 'completedOrders',
            'totalRevenue', 'paidRevenue', 'recentOrders'
        ));
    }
    public function index(Request $request)
    {
        $query = Order::with(['user', 'payment']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->whereHas('payment', function($q) use ($request) {
                $q->where('status', $request->payment_status);
            });
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'payment', 'orderDetails.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in([
                Order::STATUS_PENDING,
                Order::STATUS_PROCESSING,
                Order::STATUS_DELIVERING,
                Order::STATUS_CANCELLED,
            ])]
        ]);

        try {
            $oldStatus = $order->status;
            $newStatus = $request->status;

            Log::info("Admin attempting to update order #{$order->id} status from '{$oldStatus}' to '{$newStatus}'.");

            // --- Status Transition Validation ---
            // Prevent going back from processing to pending
            if ($oldStatus === Order::STATUS_PROCESSING && $newStatus === Order::STATUS_PENDING) {
                Log::warning("Admin tried to revert order #{$order->id} from processing to pending. Denied.");
                return redirect()->back()->with('error', 'Không thể quay lại trạng thái "Chờ xử lý" từ "Đang xử lý".');
            }

            // Prevent going back from delivering to pending or processing
            if ($oldStatus === Order::STATUS_DELIVERING && \in_array($newStatus, [Order::STATUS_PENDING, Order::STATUS_PROCESSING])) {
                Log::warning("Admin tried to revert order #{$order->id} from delivering to '{$newStatus}'. Denied.");
                $newStatusText = $newStatus === Order::STATUS_PENDING ? 'Chờ xử lý' : 'Đang xử lý';
                return redirect()->back()->with('error', 'Không thể quay lại trạng thái "' . $newStatusText . '" từ "Đang giao".');
            }

            // Prevent admin from marking as completed directly (already exists)
            if ($newStatus === Order::STATUS_COMPLETED) {
                Log::warning("Admin tried to directly set order #{$order->id} to completed. Denied.");
                return redirect()->back()->with('error', 'Trạng thái "Hoàn thành" chỉ được cập nhật khi khách hàng xác nhận.');
            }
            // --- End Status Transition Validation ---

            $order->status = $newStatus;
            $saveResult = $order->save();

            Log::info("Order #{$order->id} status save() attempt result: " . ($saveResult ? 'Success' : 'Failure') . ". Status in model post-save: " . $order->status);

            if (!$saveResult) {
                 Log::error("Failed to save status update for order #{$order->id}. Save method returned false.");
                 return redirect()->back()->with('error', 'Không thể lưu trạng thái mới vào cơ sở dữ liệu.');
            }

            return redirect()->route('admin.orders.show', $order)->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');

        } catch (\Exception $e) {
             Log::error("Exception updating status for order #{$order->id}: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage());
        }
    }

    /**
     * Validate order status transition
     *
     * @param string $oldStatus
     * @param string $newStatus
     * @return array
     */
    private function validateStatusTransition($oldStatus, $newStatus)
    {
        // Define valid transitions
        $validTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['shipping', 'cancelled'],
            'shipping' => ['completed', 'cancelled'],
            'completed' => [], // No transitions from completed
            'cancelled' => [] // No transitions from cancelled
        ];

        // Check if transition is valid
        if (in_array($newStatus, $validTransitions[$oldStatus])) {
            return ['valid' => true];
        }

        // If status is not changing, it's valid
        if ($oldStatus === $newStatus) {
            return ['valid' => true];
        }

        // Otherwise, transition is invalid
        return [
            'valid' => false,
            'message' => "Không thể chuyển trạng thái từ '{$oldStatus}' sang '{$newStatus}'"
        ];
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in([
                Order::PAYMENT_UNPAID, // Use constant
                Order::PAYMENT_PAID,   // Use constant
                Order::PAYMENT_PENDING, // Assuming you have this constant or use 'pending' string
                Order::PAYMENT_FAILED,  // If applicable
                Order::PAYMENT_REFUNDED // If applicable
            ])]
        ]);

        // Note: The original code updated Payment model status.
        // This function might need adjustments based on how payment_status on Order model is intended to be used.
        // Assuming we now want to update the payment_status field on the Order model directly.
        try {
            // Get old payment status
            $oldStatus = $order->payment_status;
            $newStatus = $request->status;

            // Prevent direct update to 'paid' if it should only happen via client confirmation
            if ($newStatus === Order::PAYMENT_PAID && $order->status !== Order::STATUS_COMPLETED) {
                 return redirect()->back()->with('error', 'Trạng thái "Đã thanh toán" chỉ được cập nhật khi đơn hàng hoàn thành.');
            }


            $order->payment_status = $newStatus;
            $order->save();

            // Also update the associated Payment record if it exists and is relevant
            if ($order->payment) {
                $order->payment->status = $newStatus; // Keep Payment record status in sync? Decide based on logic.
                $order->payment->save();
            }


            return redirect()->route('admin.orders.show', $order)->with('success', 'Trạng thái thanh toán đã được cập nhật thành công.');

        } catch (\Exception $e) {
             // Log::error("Error updating payment status for order {$order->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái thanh toán: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            // Delete related records
            $order->orderDetails()->delete();
            if ($order->payment) {
                $order->payment()->delete();
            }

            // Delete the order
            $order->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được xóa thành công'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}