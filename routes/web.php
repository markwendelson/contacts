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

Route::get('/', 'ContactsController@index');
Route::post('/contact', 'ContactsController@store')->name('contact.store');
Route::get('/contact/{id}', 'ContactsController@show');
Route::put('/contact/{id}', 'ContactsController@update');
Route::delete('/contact/{id}', 'ContactsController@destroy');




// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
