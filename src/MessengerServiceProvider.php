<?php

namespace codexivesolutions\messenger;
use Illuminate\Support\ServiceProvider;

class MessengerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'messenger');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
    public function register()
    {
        $this->registerPublishables();
    }
    public function registerPublishables()
    {
        $basePath = dirname(__DIR__);
        $arrPublishables = [
            'Messangers' => [
              "$basePath\src\Notifications" => app_path(),
              "$basePath\src\helpers" => app_path(),
              "$basePath\src\database\migrations" => database_path('migrations'),
              "$basePath\src\msgCss" => public_path(),
              "$basePath\src\layouts" =>  resource_path('views/layouts'),
            ]
        ];

        foreach ($arrPublishables as $group => $paths) {
            $this->publishes($paths,$group);
        }        
    }

  
}
