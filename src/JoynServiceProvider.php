<?php

    namespace JuniorE\LaravelJoyn;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Contracts\Container\Container;
    use Illuminate\Foundation\Application as LaravelApplication;
    use JuniorE\JoynApiClient\JoynApiClient;
    use JuniorE\LaravelJoyn\Wrappers\JoynApiWrapper;
    use Laravel\Lumen\Application as LumenApplication;
    use Laravel\Socialite\Contracts\Factory;

    class JoynServiceProvider extends ServiceProvider
    {
        const PACKAGE_VERSION = '0.0.1';

        /**
         * Bootstrap the application services.
         */
        public function boot()
        {
            $this->setupConfig();
            $this->extendSocialite();

            /*
             * Optional methods to load your package assets
             */
            // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-joyn');
            // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-joyn');
            // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
            // $this->loadRoutesFrom(__DIR__.'/routes.php');

            //if ($this->app->runningInConsole()) {
            //    $this->publishes([
            //        __DIR__ . '/../config/config.php' => config_path('laravel-joyn.php'),
            //    ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-joyn'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-joyn'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-joyn'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
            //}
        }


        /**
         * Setup the config.
         *
         * @return void
         */
        protected function setupConfig()
        {
            $source = dirname(__DIR__) . '/config/joyn.php';
            if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
                $this->publishes([$source => config_path('joyn.php')]);
            } elseif ($this->app instanceof LumenApplication) {
                $this->app->configure('joyn');
            }
            $this->mergeConfigFrom($source, 'joyn');
        }


        protected function extendSocialite()
        {
            if (interface_exists(Factory::class)) {
                $socialite = $this->app->make(Factory::class);
                $socialite->extend('joyn', static function (Container $app) use ($socialite) {
                    $config = $app['config']['services.joyn'];
                    return $socialite->buildProvider(JoynConnectProvider::class, $config);
                });
            }
        }


        /**
         * Register the application services.
         */
        public function register()
        {
            //// Automatically apply the package configuration
            //$this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-joyn');
            //
            //// Register the main class to use with the facade
            ////$this->app->singleton('laravel-joyn', function () {
            ////    return new LaravelJoyn;
            ////});

            $this->registerApiClient();
            $this->registerApiAdapter();
            $this->registerManager();
        }

        /**
         * Register the Mollie API adapter class.
         *
         * @return void
         */
        protected function registerApiAdapter()
        {
            $this->app->singleton('joyn.api',  function (Container $app) {
                $config = $app['config'];
                return new JoynApiWrapper($config, $app['joyn.api.client']);
            });
            $this->app->alias('joyn.api', JoynApiWrapper::class);
        }

        /**
         * Register the Mollie API Client.
         *
         * @return void
         */
        protected function registerApiClient()
        {
            $this->app->singleton('joyn.api.client',  function () {
                return (new JoynApiClient())->addVersionString('JoynLaravel/' . self::PACKAGE_VERSION);
            });
            $this->app->alias('joyn.api.client', JoynApiClient::class);
        }

        /**
         * Register the manager class.
         *
         * @return void
         */
        public function registerManager()
        {
            $this->app->singleton('joyn',  function (Container $app) {
                return new JoynManager($app);
            });
            $this->app->alias('joyn', JoynManager::class);
        }

        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides()
        {
            return [
                'joyn',
                'joyn.api',
                'joyn.api.client',
            ];
        }
    }
