<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExaminationController;
use App\Http\Controllers\Api\GoldController;
use App\Http\Controllers\Api\PawnController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('user', [UserController::class, 'show']);
    Route::post('user/update', [UserController::class, 'update']);

});


Route::apiResource('/pawn', PawnController::class);
Route::apiResource('/examination', ExaminationController::class);
Route::apiResource('/gold', GoldController::class);
Route::apiResource('/transaction', TransactionController::class);

Route::get('/user/check/{nationalId}', [UserController::class, 'findUserByNationalId']);
Route::get('/examination/check/{examinationId}', [ExaminationController::class, 'findExaminationById']);
Route::get('/pawn/check/{pawn_id}', [PawnController::class, 'findPawnById']);
Route::get('/transaction/check/{pawn_id}', [TransactionController::class, 'findTransactionByPawnId']);
