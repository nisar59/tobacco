<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'config','middleware' => ['permission:configuration.view']], function(){
    Route::get('index/{key}', [App\Http\Controllers\ConfigurationController::class, 'index'])->middleware('permission:configuration.view');
    Route::get('create/{key}', [App\Http\Controllers\ConfigurationController::class, 'create'])->middleware('permission:configuration.add');
    Route::post('save', [App\Http\Controllers\ConfigurationController::class, 'store'])->middleware('permission:configuration.add');
    Route::get('edit/{id}', [App\Http\Controllers\ConfigurationController::class, 'edit'])->middleware('permission:configuration.edit');
    Route::post('update', [App\Http\Controllers\ConfigurationController::class, 'update'])->middleware('permission:configuration.edit');
    Route::post('destroy/{id}', [App\Http\Controllers\ConfigurationController::class, 'destroy'])->middleware('permission:configuration.delete');
});

Route::group(['prefix'=>'product','middleware' => ['permission:product.view']], function(){
    Route::get('index', [App\Http\Controllers\ProductController::class, 'index'])->middleware('permission:product.view');
    Route::get('create', [App\Http\Controllers\ProductController::class, 'create'])->middleware('permission:product.add');
    Route::post('save', [App\Http\Controllers\ProductController::class, 'store'])->middleware('permission:product.add');
    Route::get('edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->middleware('permission:product.edit');
    Route::post('update', [App\Http\Controllers\ProductController::class, 'update'])->middleware('permission:product.edit');
    Route::post('destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->middleware('permission:product.delete');
});

Route::group(['prefix'=>'supplier','middleware' => ['permission:supplier.view']], function(){
    Route::get('index', [App\Http\Controllers\SupplierController::class, 'index'])->middleware('permission:supplier.view');
    Route::get('create', [App\Http\Controllers\SupplierController::class, 'create'])->middleware('permission:supplier.add');
    Route::post('save', [App\Http\Controllers\SupplierController::class, 'store'])->middleware('permission:supplier.add');
    Route::get('edit/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->middleware('permission:supplier.edit');
    Route::post('update', [App\Http\Controllers\SupplierController::class, 'update'])->middleware('permission:supplier.edit');
    Route::post('destroy/{id}', [App\Http\Controllers\SupplierController::class, 'destroy'])->middleware('permission:supplier.delete');
    Route::get('show/{id}', [App\Http\Controllers\SupplierController::class, 'show'])->middleware('permission:supplier.view');
});

Route::group(['prefix'=>'customer','middleware' => ['permission:customer.view']], function(){
    Route::get('index', [App\Http\Controllers\CustomerController::class, 'index'])->middleware('permission:customer.view');
    Route::get('create', [App\Http\Controllers\CustomerController::class, 'create'])->middleware('permission:customer.add');
    Route::post('save', [App\Http\Controllers\CustomerController::class, 'store'])->middleware('permission:customer.add');
    Route::get('edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->middleware('permission:customer.edit');
    Route::post('update', [App\Http\Controllers\CustomerController::class, 'update'])->middleware('permission:customer.edit');
    Route::post('destroy/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->middleware('permission:customer.delete');
    Route::get('show/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->middleware('permission:customer.view');
    Route::get('sales_ledger_export', [App\Http\Controllers\CustomerController::class, 'exportLedger'])->middleware('permission:customer.export');
});

Route::group(['prefix'=>'expense','middleware' => ['permission:expense.view']], function(){
    Route::get('index', [App\Http\Controllers\ExpenseController::class, 'index'])->middleware('permission:expense.view');
    Route::get('create', [App\Http\Controllers\ExpenseController::class, 'create'])->middleware('permission:expense.add');
    Route::post('save', [App\Http\Controllers\ExpenseController::class, 'store'])->middleware('permission:expense.add');
    Route::get('edit/{id}', [App\Http\Controllers\ExpenseController::class, 'edit'])->middleware('permission:expense.edit');
    Route::post('update', [App\Http\Controllers\ExpenseController::class, 'update'])->middleware('permission:expense.edit');
    Route::get('show/{id}', [App\Http\Controllers\ExpenseController::class, 'show'])->middleware('permission:expense.view');
    Route::post('destroy/{id}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->middleware('permission:expense.delete');
});

Route::group(['prefix'=>'cash','middleware' => ['permission:cash.view']], function(){
    Route::get('index', [App\Http\Controllers\ExpenseController::class, 'cash'])->middleware('permission:cash.view');
    Route::get('create', [App\Http\Controllers\ExpenseController::class, 'cashCreate'])->middleware('permission:cash.add');
    Route::post('save', [App\Http\Controllers\ExpenseController::class, 'store'])->middleware('permission:cash.add');
    Route::get('edit/{id}', [App\Http\Controllers\ExpenseController::class, 'cashEdit'])->middleware('permission:cash.edit');
    Route::post('update', [App\Http\Controllers\ExpenseController::class, 'update'])->middleware('permission:cash.edit');
    Route::get('show/{id}', [App\Http\Controllers\ExpenseController::class, 'cashShow'])->middleware('permission:cash.view');
    Route::post('destroy/{id}', [App\Http\Controllers\ExpenseController::class, 'cashDestroy'])->middleware('permission:cash.delete');
});

Route::group(['prefix'=>'purchase','middleware' => ['permission:purchases.view']], function(){
    Route::get('index', [App\Http\Controllers\PurchaseOrderController::class, 'index'])->middleware('permission:purchases.view');
    Route::get('create', [App\Http\Controllers\PurchaseOrderController::class, 'create'])->middleware('permission:purchases.add');
    Route::post('save', [App\Http\Controllers\PurchaseOrderController::class, 'store'])->middleware('permission:purchases.add');
    Route::get('edit/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'edit'])->middleware('permission:purchases.edit');
    Route::post('update', [App\Http\Controllers\PurchaseOrderController::class, 'update'])->middleware('permission:purchases.edit');
    Route::get('show/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'show'])->middleware('permission:purchases.view');
    Route::post('destroy', [App\Http\Controllers\PurchaseOrderController::class, 'destroy'])->middleware('permission:purchases.delete');
    Route::post('supplier', [App\Http\Controllers\PurchaseOrderController::class, 'fetchSupplier'])->middleware('permission:purchases.supplier');
    Route::post('product', [App\Http\Controllers\PurchaseOrderController::class, 'fetchProduct'])->middleware('permission:purchases.product');
    Route::get('status/update/{id}/{status}', [App\Http\Controllers\PurchaseOrderController::class, 'updateStatus'])->middleware('permission:purchases.edit');
    Route::get('return/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'getReturnOrder'])->middleware('permission:purchases.view');
});

Route::group(['prefix'=>'sales','middleware' => ['permission:sales.view']], function(){
    Route::get('index', [App\Http\Controllers\SaleOrderController::class, 'index'])->middleware('permission:sales.view');
    Route::get('create', [App\Http\Controllers\SaleOrderController::class, 'create'])->middleware('permission:sales.add');
    Route::post('save', [App\Http\Controllers\SaleOrderController::class, 'store'])->middleware('permission:sales.add');
    Route::get('edit/{id}', [App\Http\Controllers\SaleOrderController::class, 'edit'])->middleware('permission:sales.edit');
    Route::post('update', [App\Http\Controllers\SaleOrderController::class, 'update'])->middleware('permission:sales.edit');
    Route::get('show/{id}', [App\Http\Controllers\SaleOrderController::class, 'show'])->middleware('permission:sales.view');
    Route::post('destroy', [App\Http\Controllers\SaleOrderController::class, 'destroy'])->middleware('permission:sales.delete');
    Route::post('customer', [App\Http\Controllers\SaleOrderController::class, 'fetchCustomer'])->middleware('permission:sales.customer');
    Route::post('product', [App\Http\Controllers\SaleOrderController::class, 'fetchProduct'])->middleware('permission:sales.product');
});

Route::group(['prefix'=>'report','middleware' => ['permission:reports.view']], function(){
    Route::get('stock', [App\Http\Controllers\StockManagementController::class, 'index'])->middleware('permission:reports.view');
    Route::get('profit/loss', [App\Http\Controllers\ConfigurationController::class, 'profitLoos'])->middleware('permission:reports.cash_flow');
});