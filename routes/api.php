<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\AnimalsController;
use App\Http\Controllers\Api\AdminController;

// auth users
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
Route::post('login', [ApiLoginController::class, 'login']);
Route::middleware('auth:api')->get('/user', function (Request $request) {return $request->user();});

// animals route
Route::post('animals/img/{animal}', [AnimalsController::class, 'updateImg']);
Route::apiResource('/animals', AnimalsController::class);

// render images
Route::get('image/{path}/{filename}', [AdminController::class, 'viewImg'])->name('show-image');
