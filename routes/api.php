<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;




Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['admin.api'])->prefix('admin')->group(function(){
    Route::post('register',[AdminController::class,'register']);
    Route::get('show-register',[AdminController::class,'show_register']);
    Route::get('show-register/{id}',[AdminController::class,'show_register_by_id']);
    Route::post('update-register/{id}',[AdminController::class,'update_register']);
    Route::delete('delete-register/{id}',[AdminController::class,'delete_register']);

    Route::get('activation-account/{id}',[AdminController::class,'activation_account']);
    Route::get('deactivation-account/{id}',[AdminController::class,'deactivation_account']);
    
    Route::get('notdeleted-account/{id}',[AdminController::class,'notdeleted_account']);
    Route::get('deleted-account/{id}',[AdminController::class,'deleted_account']);

    
    Route::post('create-book',[AdminController::class,'create_book']);
    Route::post('update-book/{id}',[AdminController::class,'update_book']);
    Route::delete('delete-book/{id}',[AdminController::class,'delete_book']);
    Route::get('activation-book/{id}',[AdminController::class,'status_activation_book']);
    Route::get('deactivation-book/{id}',[AdminController::class,'status_deactive_book']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
