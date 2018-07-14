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

/**
 * Página de inicio y de bienvenida
 */

Route::get('/', 'IndexController')
    ->name('index');

Route::get('/inicio', 'BienvenidaController')
    ->name('bienvenida');

/** 
 * Personas Fisicas
 */
Route::get('/persona','PersonaFisicaController@view');

Route::apiResource('/personas', 'PersonaFisicaController')
    ->parameters(['personas' => 'PersonaFisica']);

/**
 * Personas jurídicas
 */

Route::get('/personas-juridicas', 'PersonaJuridicaController@view')
    ->name('juridicas.view');

Route::patch('/juridicas/{personaJuridica}/restore', 'PersonaJuridicaController@restore')
    ->name('juridicas.restore');

Route::apiResource('/juridicas', 'PersonaJuridicaController')
    ->parameters(['juridicas' => 'personaJuridica']);

/**
 * Tipos de organización
 */
Route::get('/tipos-de-organizacion', 'TipoOrganizacionController@view')
    ->name('tipos-organizacion.view');

Route::patch('/tipos-organizacion/{tipoOrganizacion}/restore', 'TipoOrganizacionController@restore')
    ->name('tipos-organizacion.restore');

Route::apiResource('/tipos-organizacion', 'TipoOrganizacionController')
    ->parameters(['tipos-organizacion' => 'tipoOrganizacion']);
