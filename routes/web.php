<?php

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

Route::get('/', 'Site\UserController@index')->name('user');

Route::post('/user/create', 'Site\UserController@ajaxCreateUser')->name('user.create');
Route::get('/user/list', 'Site\UserController@userList')->name('user.list');