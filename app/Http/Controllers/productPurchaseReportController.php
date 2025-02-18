<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\products;
use App\Models\purchase_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productPurchaseReportController extends Controller
{
    public function index()
    {
        $vendors = accounts::company()->get();
        return view('reports.purchase.index', compact('vendors'));
    }

    public function data($from, $to , $vendor)
    {
        $vendor = accounts::find($vendor);

        $purchases = DB::table('purchase_details as pd')
            ->join('purchases as p', 'p.id', '=', 'pd.purchaseID')
            ->where('p.vendorID', $vendor->id)
            ->whereBetween('p.date', [$from, $to])
            ->groupBy('pd.productID')
            ->select('pd.productID', DB::raw('ROUND(AVG(pd.pprice), 2) as avg_pprice'), DB::raw('SUM(pd.qty) as total_qty'))
            ->get();

            foreach($purchases as $purchase)
            {
                $product = products::find($purchase->productID);
                $purchase->product_code = $product->code;
                $purchase->product = $product->name;
                $purchase->product_category = $product->category->name;
                $purchase->product_stock = getStock($product->id);
            }

        return view('reports.purchase.details', compact('from', 'to', 'vendor', 'purchases'));
    }
}
