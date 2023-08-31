<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PDFServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tcpdf', function ($app) {
            return new \App\Services\CustomTCPDF();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}