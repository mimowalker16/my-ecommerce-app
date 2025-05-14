<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSales = DB::table('orders')->count();
        $totalRevenue = DB::table('orders')->sum('total_amount');
        $ordersThisMonth = DB::table('orders')
            ->where('order_date', 'like', now()->format('Y-m') . '%')
            ->count();
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as sold'))
            ->groupBy('products.name')
            ->orderByDesc('sold')
            ->limit(5)
            ->get();
        $userCount = DB::table('users')->count();
        return view('admin.dashboard', compact('totalSales', 'totalRevenue', 'ordersThisMonth', 'topProducts', 'userCount'));
    }
}
