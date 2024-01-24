<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\catalog\ClientController;
use App\Http\Controllers\Catalog\ProductController;
use App\Http\Controllers\Catalog\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setting\PermissionController;
use App\Http\Controllers\Setting\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.store');

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');

Route::get('about', [DashboardController::class, 'about'])->name('about');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('logout', [DashboardController::class, 'logout'])->name('logout');

Route::post('clients/datatables', [ClientController::class, 'datatables'])->name('clients.datatables');
Route::resource('clients', ClientController::class);

Route::get('orders/{code}/invoice', [OrderController::class, 'exports'])->name('orders.invoice');
Route::post('orders/datatables', [OrderController::class, 'datatables'])->name('orders.datatables');
Route::resource('orders', OrderController::class);

Route::post('products/details', [ProductController::class, 'details'])->name('products.details');
Route::post('products/datatables', [ProductController::class, 'datatables'])->name('products.datatables');
Route::resource('products', ProductController::class);

Route::post('users/details', [UserController::class, 'details'])->name('users.details');
Route::post('users/datatables', [UserController::class, 'datatables'])->name('users.datatables');
Route::resource('users', UserController::class);

Route::post('roles/datatables', [RoleController::class, 'datatables'])->name('roles.datatables');
Route::resource('roles', RoleController::class);

Route::post('permissions/datatables', [PermissionController::class, 'datatables'])->name('permissions.datatables');
Route::resource('permissions', PermissionController::class);

#Update user details
Route::post('update-profile/{id}', [DashboardController::class, 'updateProfile'])->name('update.profile');
Route::post('update-password/{id}', [DashboardController::class, 'updatePassword'])->name('update.password');
