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

        $this->mapHelperRoutes();

        $this->staffTableRoutes();

        $this->mapOrdersRoutes();

        $this->mapChairmanRoutes();

        $this->mapRatingRoutes();

        $this->mapAccountingRoutes();
    }

    /**
     * Define the "helper-lists" routes for the application.
     */
    protected function mapHelperRoutes()
    {
        Route::group([
            'middleware' => ['web','hr.auth'],
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/helper.php');
        });
    }

    /**
     * Define the "helper-lists" routes for the application.
     */
    protected function mapOrdersRoutes()
    {
        Route::group([
            'middleware' => ['web','hr.auth'],
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/orders.php');
        });
    }

    /**
     * Define the "accountin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAccountingRoutes()
    {
        Route::group([
            'middleware' => ['web', 'hr.auth'],
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/accounting.php');
        });
    }

    /**
     * Define the "staff-table" routes for the application.
     */
    protected function staffTableRoutes()
    {
        Route::group([
            'middleware' => ['web','hr.auth'],
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/staff-table.php');
        });
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
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapChairmanRoutes()
    {
        Route::group([
            'middleware' => ['web','hr.auth'],
            'namespace' => $this->namespace.'\Chairman',
            'prefix'    => 'chairman'
        ], function ($router) {
            require base_path('routes/chairman.php');
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapRatingRoutes()
    {
        Route::group([
            'middleware' => ['web','hr.auth','exopi'],
            'namespace' => $this->namespace.'\Rating',
            'prefix'    => 'rating'
        ], function ($router) {
            require base_path('routes/rating.php');
        });
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
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
