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
* Download order in the pdf format 
*/
 Route::get('/filter', [App\Http\ControllersCourseFilterController::class, 'apiIndex']);                    // display Product filter json response
/*
* End Order API calls 
*/