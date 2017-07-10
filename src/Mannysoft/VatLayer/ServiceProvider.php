<?php 

namespace Mannysoft\VatLayer;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Mannysoft\VatLayer\VatLayer;

class ServiceProvider extends BaseServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('vat-layer', function() {
            $apiKey = config('vatlayer.api_key');
            return new VatLayer();
        });
    }

}
