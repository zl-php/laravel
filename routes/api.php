<?php

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

use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WechatController;
use App\Http\Controllers\RedisController;
use App\Http\Controllers\RbacController;

Route::controller(IndexController::class)->group(function () {
    Route::get('index', 'index');
});

Route::controller(TestController::class)->group(function () {
    Route::get('test', 'test');
});

Route::controller(WechatController::class)->group(function () {
    Route::get('wechat', 'test');
});

Route::controller(RedisController::class)->group(function () {
    Route::get('redis', 'publish');
});

Route::controller(RbacController::class)->group(function () {
    Route::get('rbac/run', 'run');
    Route::get('rbac/test', 'test');
});

