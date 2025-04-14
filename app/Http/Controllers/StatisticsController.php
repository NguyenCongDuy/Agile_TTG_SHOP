<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display overview statistics
     */
    public function overview()
    {
        // Get total counts
        $totalUsers = User::count();
        $totalProducts = Products::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');

        // Get revenue data for the last 6 months
        $revenueData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_amount) as total')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        $revenueLabels = [];
        $revenueValues = [];
        foreach ($revenueData as $data) {
            $revenueLabels[] = "Tháng {$data->month}/{$data->year}";
            $revenueValues[] = $data->total;
        }

        // Get orders data for the last 6 months
        $ordersData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        $ordersLabels = [];
        $ordersValues = [];
        foreach ($ordersData as $data) {
            $ordersLabels[] = "Tháng {$data->month}/{$data->year}";
            $ordersValues[] = $data->total;
        }

        return view('admin.statistics.overview', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'revenueLabels',
            'revenueValues',
            'ordersLabels',
            'ordersValues'
        ));
    }

    /**
     * Display sales statistics
     */
    public function sales()
    {
        // Get sales data for the last 12 months
        $salesData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_amount) as total'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        return view('admin.statistics.sales', compact('salesData'));
    }

    /**
     * Display products statistics
     */
    public function products()
    {
        // Get top selling products
        $topProducts = Products::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        // Get products by category
        $productsByCategory = Products::select('categories.name', DB::raw('COUNT(*) as total'))
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return view('admin.statistics.products', compact('topProducts', 'productsByCategory'));
    }
}
