<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerifyIdController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminLoanController;
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
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// Delete and update notification
Route::patch('/notifications/{id}/favorite', [NotificationController::class, 'updateFavorite'])->middleware('auth:sanctum');
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->middleware('auth:sanctum');

// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Verify ID routes
    Route::post('/submit-personal-info', [VerifyIdController::class, 'storePersonalInfo']);
    Route::post('/submit-address-info', [VerifyIdController::class, 'storeAddressInfo']);
    Route::get('/user-info', [VerifyIdController::class, 'fetchLoggedInUserInfo']);
    Route::post('/personal-info', [VerifyIdController::class, 'storePersonalInfo']);
    Route::post('/address-info', [VerifyIdController::class, 'storeAddressInfo']);
    Route::get('/personal-info', [VerifyIdController::class, 'showPersonalInfo']);
    Route::get('/address-info', [VerifyIdController::class, 'showAddressInfo']);

    // Loan Application
    Route::middleware('auth:sanctum')->post('/apply-loan', [LoanController::class, 'apply']);
    
    Route::get('/loan-applications', [LoanController::class, 'index']);
    Route::get('/loan-status', [LoanController::class, 'index']);
   
    //coopy
    Route::get('/balance', [BankAccountController::class, 'check']);


    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
});

// Testing items if it works
Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'store']);

// Admin routes for user management
Route::prefix('admin')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/user-info/{id}', [VerifyIdController::class, 'fetchUserInfo'])->middleware('auth:sanctum');
    Route::post('/users', [AdminUserController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->middleware('auth:sanctum');

     // Loan management routes
     Route::get('/loans', [AdminLoanController::class, 'index'])->middleware('auth:sanctum');
     Route::get('/loans/{id}', [AdminLoanController::class, 'show'])->middleware('auth:sanctum');
     Route::post('/loans', [AdminLoanController::class, 'store'])->middleware('auth:sanctum');
     Route::put('/loans/{id}', [AdminLoanController::class, 'update'])->middleware('auth:sanctum');
     Route::delete('/loans/{id}', [AdminLoanController::class, 'destroy'])->middleware('auth:sanctum');
});
