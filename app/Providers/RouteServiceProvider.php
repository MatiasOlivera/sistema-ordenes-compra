<?php

namespace App\Providers;

use App\PersonaJuridica;
use App\TipoOrganizacion;
use App\Empresa;
use App\ActividadEconomica;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        /**
         * Personas jurídicas
         */

        Route::bind('personaJuridica', function ($id) {
            return PersonaJuridica::withTrashed()
                ->where('id', $id)
                ->firstOrFail();
        });

        /**
         * Tipos de organización
         */
        Route::bind('tipoOrganizacion', function ($id) {
            return TipoOrganizacion::withTrashed()
                ->where('id', $id)
                ->firstOrFail();
        });

        /**
         * Empresas
         */
        Route::bind('empresa', function ($id) {
            return Empresa::withTrashed()
                ->where('id', $id)
                ->firstOrFail();
        });

        /**
         * Actividades económicas
         */
        Route::bind('actividadEconomica', function ($id) {
            return ActividadEconomica::withTrashed()
                ->where('id', $id)
                ->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
