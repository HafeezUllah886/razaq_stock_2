<?php

use App\Http\Controllers\dailycashbookController;
use App\Http\Controllers\ledgerReportController;
use App\Http\Controllers\productPurchaseReportController;
use App\Http\Controllers\profitController;
use App\Http\Controllers\SalesmanReceiveReportController;
use App\Http\Controllers\WarehouseReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/reports/profit', [profitController::class, 'index'])->name('reportProfit');
    Route::get('/reports/profit/{from}/{to}', [profitController::class, 'data'])->name('reportProfitData');

    Route::get('/reports/dailycashbook', [dailycashbookController::class, 'index'])->name('reportCashbook');
    Route::get('/reports/dailycashbook/{date}', [dailycashbookController::class, 'details'])->name('reportCashbookData');

    Route::get('/reports/ledger', [ledgerReportController::class, 'index'])->name('reportLedger');
    Route::get('/reports/ledger/{from}/{to}/{type}', [ledgerReportController::class, 'data'])->name('reportLedgerData');
    
    Route::get('/reports/purchase', [productPurchaseReportController::class, 'index'])->name('reportPurchase');
    Route::get('/reports/purchase/{from}/{to}/{vendor}', [productPurchaseReportController::class, 'data'])->name('reportPurchaseData');

    Route::get('/reports/sale', [SalesmanReceiveReportController::class, 'index'])->name('reportSale');
    Route::get('/reports/sale/{from}/{to}/{salesman}', [SalesmanReceiveReportController::class, 'data'])->name('reportSaleData');
    
    Route::get('/reports/warehouse', [WarehouseReportController::class, 'index'])->name('reportWarehouse');
    Route::get('/reports/warehouse/{warehouse}', [WarehouseReportController::class, 'data'])->name('reportWarehouseData');


});
