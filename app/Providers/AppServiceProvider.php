<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        //
        \Sofa\Eloquence\Builder::setParserFactory(new \Sofa\Eloquence\Searchable\ParserFactory);

        // Force HTTPS in production environment
        if (env('APP_ENV') == 'production') {
            $url->forceSchema('https');
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
