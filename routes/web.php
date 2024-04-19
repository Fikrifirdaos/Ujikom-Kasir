<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::get('/user/create', function () {
    return view('Login.create');
});

Route::get("/", [LoginController::class, "index"]);
Route::post("/auth", [LoginController::class, "auth"])->name('auth.login');
Route::get("/auth/logout", [LoginController::class, "logout"])->name('auth.logout');

Route::middleware("isLogin")->group(function (){
    // dashboard
    Route::get("/dashboard", [DashboardController::class, "index"])->name('dashboard');

    Route::get("/stock", [StockController::class, "index"])->name("stock");
    Route::post("/stock/create", [StockController::class, "store"])->name("stock.store");
    Route::post("/stock/add/{id}", [StockController::class, "updateStock"])->name("stock.nambah");
    Route::post("/stock/update/{id}", [StockController::class, "update"])->name("stock.update");


    // Penjualan
    Route::get("/penjualan", [PenjualanController::class, "index"])->name('penjualan');
    Route::post("/penjualan/checkout", [PenjualanController::class, "store"])->name("penjualan.checkout");
    Route::post("/penjualan/payment", [PenjualanController::class, "create"])->name("penjualan.payment");
    Route::middleware("isAdmin")->group(function(){

    });
});
