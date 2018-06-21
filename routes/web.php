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

/**
 * Autenticación
 */

Route::post('/login', 'Auth\LoginController@login')
    ->name('login');

Route::get('/logout', 'Auth\LoginController@logout')
    ->name('logout');

Route::post('/registro', 'Auth\RegisterController@register')
    ->name('registro');

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/inicio', function() {
    return view('bienvenida');
})->middleware('auth')->name('bienvenida');
