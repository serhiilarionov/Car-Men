<?php

namespace Modules\News\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->registerConfig();
        $this->registerViews();

        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('news.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'news'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/news');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/news';
        }, \Config::get('view.paths')), [$sourcePath]), 'news');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/news');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'news');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'news');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
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
            'middleware' => ['web', 'auth:web'],
            'namespace' => 'Modules\News\Http\Controllers',
            'prefix' => 'news',
            'as' => 'news.'
        ], function ($router) {
            require base_path('Modules/News/Routes/web.php');
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
            'prefix' => 'api/v1/news',
            'as' => 'api.news.',
        ], function ($router) {
            require base_path('Modules/News/Routes/api.php');
        });
    }

}
