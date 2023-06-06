<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\ProductFilterController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
* Customer API calls 
*/
Route::get('/customer', [CustomerController::class, 'index']);      // display customer details
Route::post('/customer', [CustomerController::class, 'store']);     // store customer details
/*
* End Customer API calls
*/

/*
* Product API calls
*/
Route::get('/products', [ProductController::class, 'index']);                // display product details
Route::post('/product', [ProductController::class, 'store']);               // store product details
Route::patch('/product/{id}', [ProductController::class, 'update']);        // update product details
Route::delete('/product/{id}', [ProductController::class, 'destroy']);      // delete product by id
/*
* End Product API calls
*/

/*
* Order API calls 
*/
    Route::get('/order', [OrderController::class, 'index']);                    // display order details
    Route::post('/order', [OrderController::class, 'store']);                   // store order details
    Route::put('/order/{id}', [OrderController::class, 'update']);              // update order details, data: customer_id
    Route::put('/order-item/{id}', [OrderItemsController::class, 'update']);    // update order item details, data: product_id, quantity, order_id
/*
* End Order API calls 
*/

/*
* Download order in the pdf format 
*/
    Route::get('/filter', [CourseFilterController::class, 'apiIndex']);                    // display Product filter json response
/*
* End Order API calls 
*/