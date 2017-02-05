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

//authentication routes
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');


//basic application entry
Route::get('/','PostsController@index');

//about us page 
Route::get('/about','AboutController@index');

//contact us page 
Route::get('/contact','ContactController@index');

//receive message from contact us page 
Route::post('/contact','ContactController@saveMessage');

//resource routes for posts
Route::resource('posts', 'PostsController');


//resource route for comments
Route::resource('comment', 'CommentsController');




