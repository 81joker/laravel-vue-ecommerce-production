<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', action: [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('/products', controller: ProductController::class);
    Route::apiResource('categories', CategoryController::class)->except(['show']);
    Route::get('/countries', [CustomerController::class, 'countries']);
    Route::get('/categories/tree', [CategoryController::class, 'getAsTree']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::get('orders/statuses', [OrderController::class, 'getStatuses']);
    Route::post('orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
    Route::get('orders/{order}', [OrderController::class, 'view']);

    // Dashbaord Routes
    Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
    Route::get('/dashboard/products-count', [DashboardController::class, 'activeProducts']);
    Route::get('/dashboard/orders-count', [DashboardController::class, 'paidOrders']);
    Route::get('/dashboard/income-count', [DashboardController::class, 'totalIncome']);
    Route::get('/dashboard/orders-by-country', [DashboardController::class, 'ordersByCountry']);
    Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);
    Route::get('/dashboard/latest-orders', [DashboardController::class, 'latestOrders']);

    // Reports Routes
    Route::get('/reports/orders', [ReportController::class, 'orders']);
    Route::get('/reports/customers', [ReportController::class, 'customers']);

});
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route::get('/user', [AuthController::class, 'getUser']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
