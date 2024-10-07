<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
class ChartCotroller extends Controller
{
    public function showcharts()
    {
        $categories = Category::withCount('products')->get();
        $products = Products::all();
    
        return view('admin.report', compact('categories', 'products'));
    }
    
}
