<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseFilterController;


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
 Route::get('/filter', [CourseFilterController::class, 'apiIndex']);                    // display Product filter json response
/*
* End Order API calls 
*/