<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\products;
use App\Models\warehouses;
use Illuminate\Http\Request;

class WarehouseReportController extends Controller
{
    public function index()
    {
        $warehouses = warehouses::all();
        return view('reports.warehouse.index', compact('warehouses'));
    }

    public function data(warehouses $warehouse)
    {
        $products = products::all();
        foreach($products as $product)
        {
            $product->stock = getStockByWarehouse($product->id, $warehouse->id);
            $product->stock_cr = getWarehouseProductCr($product->id, $warehouse->id);
            $product->stock_db = getWarehouseProductDb($product->id, $warehouse->id);
            $product->stock_value = warehouseProductStockValue($product->id, $warehouse->id);
        }

        return view('reports.warehouse.details', compact('products', 'warehouse'));
    }
}
