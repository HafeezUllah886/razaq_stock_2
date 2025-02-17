<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\expenses;
use App\Models\products;
use App\Models\purchase_details;
use App\Models\sale_details;
use App\Models\sales;
use Carbon\Carbon;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $products = products::with('category')->select('id', 'code', 'name', 'alert', 'catID')->get();
        foreach($products as $product){
            $product->stock = getStock($product->id);
        }
        return view('dashboard.index', compact('products'));
    }
}
