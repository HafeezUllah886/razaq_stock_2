<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesmanReceiveReportController extends Controller
{
    public function index()
    {
        $salesmen = accounts::salesman()->get();
        return view('reports.sale.index', compact('salesmen'));
    }

    public function data($from, $to , $salesman)
    {
        $salesman = accounts::find($salesman);

        $sales = DB::table('sale_details as pd')
            ->join('sales as p', 'p.id', '=', 'pd.salesID')
            ->where('p.customerID', $salesman->id)
            ->whereBetween('p.date', [$from, $to])
            ->groupBy('pd.productID')
            ->select('pd.productID', DB::raw('SUM(pd.qty) as total_qty'))
            ->get();

            foreach($sales as $sale)
            {
                $product = products::find($sale->productID);
                $sale->product_code = $product->code;
                $sale->product = $product->name;
                $sale->product_category = $product->category->name;
                $sale->product_stock = getStock($product->id);
            }

        return view('reports.sale.details', compact('from', 'to', 'salesman', 'sales'));
    }
}
