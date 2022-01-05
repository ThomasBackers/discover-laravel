<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;

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

/**
 * Homepage routes
 */
Route::get('/', [PagesController::class, 'index']);

/**
 * Blog routes
 * The 'resource' route type is available because of PostController being created
 * through Artisan with a --resource flag. => php artisan route:list --name=blog
 * to see exactly what it made
 */
Route::resource('/blog', PostsController::class);

/**
 * Routes needed for authentication
 * generated automatically because of the --auth flag during tailwind import
 */
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
