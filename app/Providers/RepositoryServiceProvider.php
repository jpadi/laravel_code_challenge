<?php

namespace App\Providers;

use App\BoundedContext\Backoffice\Dashboard\Infra\Repositories\Eloquent\DashboardDomainRepositoryEloquent;
use App\BoundedContext\Backoffice\Dashboard\Infra\Repositories\Eloquent\DashboardStatsRepositoryEloquent;
use App\BoundedContext\Backoffice\Dashboard\Model\Repositories\DashboardDomainRepository;
use App\BoundedContext\Backoffice\Dashboard\Model\Repositories\DashboardStatsRepository;
use App\BoundedContext\Backoffice\Domains\Infra\Repositories\Eloquent\DomainsDomainRespositoryEloquent;
use App\BoundedContext\Backoffice\Domains\Model\Repositories\DomainsDomainRepository;
use App\BoundedContext\Backoffice\Settings\Infra\Repositories\Eloquent\SettingsSettingRepositoryEloquent;
use App\BoundedContext\Backoffice\Settings\Model\Repositories\SettingsSettingRepository;
use App\BoundedContext\Backoffice\Shorter\Infra\Repository\Eloquent\ShorterUrlEloquentRepository;
use App\BoundedContext\Backoffice\Shorter\Infra\Repository\Http\ShorterShortUrlHttpRepository;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterShortUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $map = [
            // shorter module
            ShorterUrlRepository::class  => ShorterUrlEloquentRepository::class,
            ShorterShortUrlRepository::class => ShorterShortUrlHttpRepository::class
        ];

        foreach ($map as $interface => $implementation) {
            $this->app->singleton($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
