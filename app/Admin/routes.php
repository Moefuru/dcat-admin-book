<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->get('/book-list-select', 'Api\BookController@BookListSelect');

    $router->resource('books', 'BookController');
    $router->resource('book-category', 'BookCategoryController');
    $router->resource('book-chapters', 'BookChapterController');
    $router->resource('app-user', 'AppUserController');
    $router->resource('hot-search', 'HotSearchController');
});
