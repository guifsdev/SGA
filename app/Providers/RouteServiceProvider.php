<?php

namespace App\Providers;

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
        //

        parent::boot();
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

        $this->mapAjusteRoutes();

        $this->mapEstudanteRoutes();

        $this->mapAdminRoutes();

        $this->mapAdminAjusteRoutes();

        $this->mapAdminCertificadosRoutes();

        $this->mapAdminDisciplinasRoutes();

        $this->mapAdminEstudantesRoutes();

        $this->mapAdminEventosRoutes();

        $this->mapTemplatesRoutes();

        $this->mapAdminUsuariosRoutes();

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
             ->group(base_path('routes/web/web.php'));
    }
    protected function mapAjusteRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/estudante/ajuste.php'));
    }
    protected function mapEstudanteRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/estudante/estudante.php'));
    }
    protected function mapAdminRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/admin.php'));
    }    
    protected function mapAdminAjusteRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/ajuste.php'));
    }
    protected function mapAdminCertificadosRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/certificados.php'));
    }
    protected function mapAdminDisciplinasRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/disciplinas.php'));
    }
    protected function mapAdminEstudantesRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/estudantes.php'));
    }
    protected function mapAdminEventosRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/eventos.php'));
    }
    protected function mapTemplatesRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/templates.php'));
    }
    protected function mapAdminUsuariosRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin/usuarios.php'));
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
             ->group(base_path('routes/api/api.php'));
    }

}
