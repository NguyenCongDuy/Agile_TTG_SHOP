<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            'status' => 'required|in:pending,processing,shipping,completed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            // Get old status for comparison
            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Validate status transitions
            $validTransition = $this->validateStatusTransition($oldStatus, $newStatus);

            if (!$validTransition['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => $validTransition['message']
                ], 400);
            }

            // Only allow admin to change to completed if the status is not already completed
            // Completed status should be set by the customer
            if ($newStatus === 'completed' && $oldStatus !== 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ khách hàng mới có thể xác nhận hoàn thành đơn hàng'
                ], 400);
            }

            // Update order status
            $order->update(['status' => $newStatus]);

            // Add notification logic here if needed
            // For example, you could send an email to the customer
            // or create a notification record in the database

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Trạng thái đơn hàng đã được cập nhật thành công',
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
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
            'status' => 'required|in:pending,paid,unpaid'
        ]);

        try {
            DB::beginTransaction();

            // Get old payment status for comparison
            $oldStatus = $order->payment ? $order->payment->status : null;

            if (!$order->payment) {
                $order->payment()->create([
                    'status' => $request->status,
                    'amount' => $order->total_amount,
                    'method' => $order->payment_method ?? 'bank_transfer'
                ]);
            } else {
                $order->payment->update(['status' => $request->status]);
            }

            // Add notification logic here if needed
            // For example, you could send an email to the customer
            // or create a notification record in the database

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Trạng thái thanh toán đã được cập nhật thành công',
                'old_status' => $oldStatus,
                'new_status' => $request->status
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
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