<?php

use App\Http\Controllers\AuditLog\AuditLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IpAddress\IpAddressController;
use App\Http\Controllers\IpAddressLabel\LabelController;
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

Route::post('/login', [LoginController::class, 'login']);

Route::post('/ip-address', [IpAddressController::class, 'store']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('ip-address', IpAddressController::class)->except(['update']);
    Route::put('/ip-address/{ip_address}/{label?}', [IpAddressController::class, 'update']);

    Route::group(['prefix' => 'labels'], function () {
        Route::get('/', [LabelController::class, 'index']);
        Route::post('/{ip_address}', [LabelController::class, 'store']);
    });

    Route::get('/audit-logs', [AuditLogController::class, 'index']);
});
