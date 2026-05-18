<?php

namespace Iqtechnology\FfProxy;

use Illuminate\Support\ServiceProvider;

class ProxyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/formflex.php',
            'formflex'
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config/formflex.php' => config_path('formflex.php'),
        ], 'formflex-config');

        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
    }
}
