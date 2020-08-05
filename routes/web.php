<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    return "Cache is cleared";
});

Route::get('/', function () {
    return view('app');
});

Route::get('/home', function () {
    return view('app');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/get-user', 'UserController@getUser');
Route::get('/get-user-group', 'UserController@getUserGrp');

Route::post('/user/update', 'UserController@update');
Route::post('/user/change_password', 'UserController@change_password');
Route::get('/users/show/{id}', 'UserController@show');
Route::post('/users/update/group/{id}', 'UserController@update_group');

Route::get('/get-users', 'UserController@getUsers');

Route::get('/groups/index', 'GroupController@index');
Route::post('/groups/store', 'GroupController@store');

Route::get('/statuses/index', 'StatusController@index');
Route::post('/statuses/store', 'StatusController@store');
Route::get('/statuses/show/{id}', 'StatusController@show');
Route::post('/statuses/update/{id}', 'StatusController@update');


Route::get('/clients/index', 'ClientController@index');
Route::post('/clients/store', 'ClientController@store');
Route::get('/clients/show/{id}', 'ClientController@show');
Route::post('/clients/update/{id}', 'ClientController@update');

Route::get('/tasks/index', 'TaskController@index');
Route::post('/tasks/store', 'TaskController@store');
Route::get('/tasks/show/{id}', 'TaskController@show');
Route::post('/tasks/update/{id}', 'TaskController@update');
Route::post('/tasks/delete/{id}', 'TaskController@destroy');

Route::get('/projects/index', 'ProjectController@index');
Route::post('/projects/store', 'ProjectController@store');
Route::get('/projects/show/{id}', 'ProjectController@show');
Route::post('/projects/update/{id}', 'ProjectController@update');
