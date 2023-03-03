<?php

use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;

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

# ------ Unauthenticated routes ------ #
Route::get('/', [AuthenticatedSessionController::class, 'create']);
require __DIR__.'/auth.php';


# ------ Authenticated routes ------ #
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [RouteController::class, 'dashboard'])->name('home'); # dashboard

    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'myProfile'])->name('profile');
        Route::put('/change-ava', [ProfileController::class, 'changeFotoProfile'])->name('change-ava');
        Route::put('/change-profile', [ProfileController::class, 'changeProfile'])->name('change-profile');
    }); # profile group

    # ------ DataTables routes ------ #
    Route::prefix('data')->name('datatable.')->group(function(){
        Route::get('/users', [DataTableController::class, 'getUsers'])->name('users');
    });

    Route::get('/datatable/users', [UserController::class, 'userDataTable'])->name('users.datatables');

    Route::middleware('roles:admin')->group(function(){

        Route::resource('users', UserController::class);
        Route::resource('items', ItemController::class);
    });

    Route::prefix('auctions')->name('auctions.')->group(function(){
        Route::get('/{auctionId}/create-auction', [AuctionController::class, 'createAuction'])->name('create-auction');
        Route::post('/{auctionId}/create-auction', [AuctionController::class, 'storeAuction'])->name('store-auction');
        Route::delete('/{auctionId}/delete-auction/{historyId}', [AuctionController::class, 'deleteAuction'])->name('destroy-auction');
        Route::put('/{auctionId}/status-auction/{historyId}', [AuctionController::class, 'setStatusAuction'])->name('status-auction');
    });
    Route::resource('auctions', AuctionController::class);
});
