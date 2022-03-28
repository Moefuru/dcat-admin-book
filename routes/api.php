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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'login'], function () {
    Route::post('userLogin', [App\Http\Controllers\Api\UserController::class, 'userLogin']);//用户登录
});

Route::group(['prefix' => 'applet','middleware'=>'check.login'], function () {
    Route::post('/getCategory', [App\Http\Controllers\Api\BookController::class, 'getCategory']);//获取书籍分类
    Route::post('/getBookList', [App\Http\Controllers\Api\BookController::class, 'getBookList']);//获取书籍列表
    Route::post('/getChapterList', [App\Http\Controllers\Api\BookController::class, 'getChapterList']);//获取章节列表
    Route::post('/getChapterDetail', [App\Http\Controllers\Api\BookController::class, 'getChapterDetail']);//获取章节详情
    Route::post('/getHotSearch', [App\Http\Controllers\Api\BookController::class, 'getHotSearch']);//获取热门搜索词

    Route::post('/updateUserInfo', [App\Http\Controllers\Api\UserController::class, 'updateUserInfo']);//更新用户信息

    Route::post('/getCollection', [App\Http\Controllers\Api\CollectionController::class, 'getCollection']);//获取收藏
    Route::post('/addCollection', [App\Http\Controllers\Api\CollectionController::class, 'addCollection']);//添加收藏
    Route::post('/RemoveCollection', [App\Http\Controllers\Api\CollectionController::class, 'RemoveCollection']);//删除收藏
});

//测试专用
Route::any('/getCategory', [App\Http\Controllers\Api\BookController::class, 'getCategory']);//获取书籍分类
Route::any('/getBookList', [App\Http\Controllers\Api\BookController::class, 'getBookList']);//获取书籍列表
Route::any('/getChapterList', [App\Http\Controllers\Api\BookController::class, 'getChapterList']);//获取章节列表
Route::any('/getChapterDetail', [App\Http\Controllers\Api\BookController::class, 'getChapterDetail']);//获取章节详情
Route::post('/getCollection', [App\Http\Controllers\Api\CollectionController::class, 'getCollection']);//获取收藏
Route::post('/addCollection', [App\Http\Controllers\Api\CollectionController::class, 'addCollection']);//添加收藏
Route::post('/RemoveCollection', [App\Http\Controllers\Api\CollectionController::class, 'RemoveCollection']);//删除收藏
Route::post('/getHotSearch', [App\Http\Controllers\Api\BookController::class, 'getHotSearch']);//获取热门搜索词
