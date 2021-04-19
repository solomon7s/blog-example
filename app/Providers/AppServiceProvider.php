<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Account\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->parseMigrationFolders();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

    }


    private function parseMigrationFolders(): void
    {
        $mainPath = database_path('migrations');
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }


}
