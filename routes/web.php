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
 * Relación entre personas jurídicas y empresas
 */
Route::post('/juridicas/{personaJuridica}/empresas/{empresa}', 'JuridicaEmpresaController@store')
    ->name('juridicas_empresas.store');

Route::delete('/juridicas/{personaJuridica}/empresas/{empresa}', 'JuridicaEmpresaController@destroy')
    ->name('juridicas_empresas.destroy');

/**
 * Tipos de organización
 */
Route::get('/tipos-de-organizacion', 'TipoOrganizacionController@view')
    ->name('tipos-organizacion.view');

Route::patch('/tipos-organizacion/{tipoOrganizacion}/restore', 'TipoOrganizacionController@restore')
    ->name('tipos-organizacion.restore');

Route::apiResource('/tipos-organizacion', 'TipoOrganizacionController')
    ->parameters(['tipos-organizacion' => 'tipoOrganizacion']);

/**
 * Empresas
 */
Route::get('/empresa', 'EmpresaController@view')
    ->name('empresas.view');

Route::patch('/empresas/{empresa}/restore', 'EmpresaController@restore')
    ->name('empresas.restore');

Route::apiResource('/empresas', 'EmpresaController');

/**
 * Actividades econonómicas
 */
Route::apiResource('/actividades-economicas', 'ActividadEconomicaController')
    ->only(['index']);

/**
 * Rubros
 */

Route::patch('/rubros/{rubro}/restore', 'RubroController@restore')
    ->name('rubros.restore');

Route::apiResource('/rubros', 'RubroController');

/**
 * Proveedores
 */
Route::post('/empresas/{empresa}/proveedor', 'ProveedorController@store')
    ->name('proveedores.store');

Route::delete('/empresas/{empresa}/proveedor', 'ProveedorController@destroy')
    ->name('proveedores.destroy');

Route::apiResource('/proveedores', 'ProveedorController')
    ->only(['index'])
    ->parameters(['proveedores' => 'proveedor']);