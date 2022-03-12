<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::get('/recipe-categories', 'App\Http\Controllers\CategoriesController@listCategories');
Route::post('/recipe-categories', 'App\Http\Controllers\CategoriesController@create');
Route::put('/recipe-categories/{id}', 'App\Http\Controllers\CategoriesController@update');
Route::delete('/recipe-categories/{id}', 'App\Http\Controllers\CategoriesController@delete');

Route::get('/recipes', 'App\Http\Controllers\RecipesController@getRecipes');
Route::post('/recipes', 'App\Http\Controllers\RecipesController@create');

// Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
// //API route for login user
// Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

// //Protecting Routes
// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::get('/profile', function(Request $request) {
//         return auth()->user();
//     });

//     // API route for logout user
//     Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
// });
