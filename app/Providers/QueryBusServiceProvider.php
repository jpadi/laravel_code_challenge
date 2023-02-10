<?php

namespace App\Providers;

use App\BoundedContext\Backoffice\Auth\Application\Query\CheckAuthTokenQuery;
use App\BoundedContext\Backoffice\Auth\Application\QueryHandler\CheckAuthTokenQueryQueryHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\Queries\DashboardStatsQuery;
use App\BoundedContext\Backoffice\Dashboard\Application\QueryHandlers\DashboardStatsQueryHandler;
use App\BoundedContext\Backoffice\Domains\Application\Queries\DomainsDomainQuery;
use App\BoundedContext\Backoffice\Domains\Application\QueryHandlers\DomainsDomainQueryHandler;
use App\BoundedContext\Backoffice\Settings\Application\Queries\SettingsSettingGetQuery;
use App\BoundedContext\Backoffice\Settings\Application\QueryHandlers\SettingsSettingGetQueryHandler;
use App\BoundedContext\Backoffice\Shorter\Application\Query\GetShorterUrlQuery;
use App\BoundedContext\Backoffice\Shorter\Application\Query\SearchShorterUrlQuery;
use App\BoundedContext\Backoffice\Shorter\Application\QueryHandler\GetShorterUrlQueryHandler;
use App\BoundedContext\Backoffice\Shorter\Application\QueryHandler\SearchShorterUrlQueryHandler;
use App\BoundedContext\Core\Infra\QueryBus\SimpleInMemory\SimpleInMemoryQueryBus;
use App\BoundedContext\Core\Model\QueryBus\QueryBus;
use App\BundlesContext\Backoffice\Domains\Application\kk\kk;
use Illuminate\Support\ServiceProvider;

class QueryBusServiceProvider extends ServiceProvider
{

    /**
     * @var SimpleInMemoryQueryBus
     */
    private $queryBus;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $queryBus = new SimpleInMemoryQueryBus();
        $this->queryBus = $queryBus;
        $this->app->singleton(QueryBus::class, function ($app) use ($queryBus) {
            return $queryBus;
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $map = [
            // auth module
            CheckAuthTokenQuery::class => CheckAuthTokenQueryQueryHandler::class,

            // shorter module
            SearchShorterUrlQuery::class => SearchShorterUrlQueryHandler::class,
            GetShorterUrlQuery::class => GetShorterUrlQueryHandler::class

        ];

        foreach ($map as $name => $handler) {
            $this->queryBus->addHandler($name, [$this->app->make($handler), 'handle']);
        }
    }
}
