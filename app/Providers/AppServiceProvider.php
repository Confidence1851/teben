<?php

namespace App\Providers;

use App\Helpers\AppConstants;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        $this->app->extend('command.model.make', function ($command, $app) {
            return new ModelMakeCommand($app['files']);
        });

        view()->composer('*',function($view){

            $view->with([
                'logo_img' => route('index').env('ASSET_URL').'/logo.png',
                'favicon_img' => route('index').env('ASSET_URL').'/logo.png',
                'user_img' => route('index').env('ASSET_URL').'/user.png',
                'web_source' => route('index').env('ASSET_URL').'/web',
                'admin_source' => route('index').env('ASSET_URL').'/dashboard',
                // 'userRole' => $this->bloggerRole,
                // 'bloggerRole' => $this->bloggerRole,
                // 'instructorRole' => $this->instructorRole,
                // 'subAdminRole' => $this->subAdminRole,
                // 'adminRole' => $this->adminRole,
                'activeStatus' => AppConstants::ACTIVE_STATUS,
                'pendingStatus' => AppConstants::PENDING_STATUS,
                'inactiveStatus' => AppConstants::INACTIVE_STATUS,
            ]);
        });
    }
}
