<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function dashboard () {
        $products_count = Product::where('user_id', auth()->id())->count();
        return view('web.business.dashboard.index', compact('products_count'));
    }
}
