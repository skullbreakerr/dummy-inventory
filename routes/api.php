<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user-details',[ApiController::class,'userDetails']);
// Inventory
Route::get('/get-inventory',[InventoryController::class,'getInventory']);
Route::post('/add-inventory',[InventoryController::class,'addInventory']);
Route::post('/update-inventory',[InventoryController::class,'updateInventory']);
Route::get('/delete-inventory',[InventoryController::class,'deleteInventory']);
// Product
Route::get('/get-product',[ProductController::class,'getProduct']);
Route::post('/add-product',[ProductController::class,'addProduct']);
Route::post('/update-product',[ProductController::class,'updateProduct']);
Route::get('/delete-product',[ProductController::class,'deleteProduct']);

// openAi Request
Route::post('/ask-question',[ApiController::class,'askQuestion']);

// Push Notification
Route::post('/fcm-token', [PushNotificationController::class, 'updateToken'])->name('fcmToken');
Route::post('/send-notification',[PushNotificationController::class,'notification'])->name('notification');
// Route::get('/send-notification',[PushNotificationController::class,'getnotification'])->name('getnotification');
Route::post('/chat-file',[ApiController::class, 'chatFile']);

// Upload image file
Route::post("/upload-image",[ApiController::class, "UploadImage"])->name("upload-image");