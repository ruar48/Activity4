<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\User;

class AdminController extends Controller
{
    public function admindashboard()
    {
        $ordersCount = 0; 
        $usersCount = User::count(); 
        $productsCount = Products::count(); 
        $categoriesCount = Category::count();
    
        return view('admin.dashboard', compact('ordersCount', 'usersCount', 'productsCount', 'categoriesCount'));
    }
    
    
}
