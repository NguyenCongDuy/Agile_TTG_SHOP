<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function overview()
    {
        return view('admin.statistics.overview');
    }

    public function sales()
    {
        return view('admin.statistics.sales');
    }

    public function products()
    {
        return view('admin.statistics.products');
    }
}
