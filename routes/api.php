<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/unauthorized', 'api\v1\LoginController@unauthorized')->name('unauthorized');
Route::prefix('/v1')->group(function() {
    Route::post('/login', 'api\v1\LoginController@login');    
    Route::get('/categories', 'api\v1\CategoryController@index');
    Route::get('/products/{category_id?}', 'api\v1\ProductController@index');

    Route::post('/categories', 'api\v1\CategoryController@store');
    Route::put('/categories/{id}', 'api\v1\CategoryController@update');
    Route::delete('/categories/{id}', 'api\v1\CategoryController@destroy');    
    Route::post('/products', 'api\v1\ProductController@store');
    Route::put('/products/{id}', 'api\v1\ProductController@update');
    Route::delete('/products/{id}', 'api\v1\ProductController@destroy');
});
