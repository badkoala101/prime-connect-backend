<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerifyIdController;
use App\Http\Controllers\BankAccountController;

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

// Public routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

// Delete and update notification
Route::patch('/notifications/{id}/favorite', [NotificationController::class, 'updateFavorite'])->middleware('auth:sanctum');
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->middleware('auth:sanctum');

// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //new verify id
    Route::post('/submit-personal-info', [VerifyIdController::class, 'storePersonalInfo']);
    Route::post('/submit-address-info', [VerifyIdController::class, 'storeAddressInfo']);
    Route::get('/user-info', [VerifyIdController::class, 'fetchUserInfo']);
    //verify id
    Route::post('/personal-info', [VerifyIdController::class, 'storePersonalInfo']);
Route::post('/address-info', [VerifyIdController::class, 'storeAddressInfo']);
Route::get('/personal-info', [VerifyIdController::class, 'showPersonalInfo']);
Route::get('/address-info', [VerifyIdController::class, 'showAddressInfo']);

    // Loan Application
    Route::post('/apply-loan', [LoanApplicationController::class, 'store']);
    Route::get('/loan-applications', [LoanApplicationController::class, 'index']);
    Route::get('/loan-status', [LoanApplicationController::class, 'index']);

    //Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    //check balance
    Route::get('/checkbalance', [BankAccountController::class, 'check']);
    
});

// Testing items if it works
Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'store']);
