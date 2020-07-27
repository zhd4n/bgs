<?php

use App\Http\Controllers\ParticipantController;
use App\User;
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

Route::get('/install', function () {
    Artisan::call('migrate:fresh --seed --force --quiet');

    $user = User::first();

    return [
        'installed'  => true,
        'auth_token' => $user->createToken('api')->plainTextToken,
        'message'    => 'Now you can start adding participants using http://localhost:8080/api/participants',
    ];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('participants', ParticipantController::class);
});
