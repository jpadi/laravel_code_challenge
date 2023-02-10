<?php

namespace App\Providers;

use App\BoundedContext\Backoffice\Dashboard\Application\EventHandlers\DashboardDomainCreatedEventHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\EventHandlers\DashboardDomainDeletedEventHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\EventHandlers\DashboardDomainUpdatedEventHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\EventHandlers\DomainsDomainCreatedEventHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\EventHandlers\DomainsDomainDeletedEventHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\EventHandlers\DomainsDomainUpdatedEventHandler;
use App\BoundedContext\Backoffice\Dashboard\Model\Events\DashboardDomainCreated;
use App\BoundedContext\Backoffice\Dashboard\Model\Events\DashboardDomainDeleted;
use App\BoundedContext\Backoffice\Dashboard\Model\Events\DashboardDomainUpdated;
use App\BoundedContext\Backoffice\Domains\Model\Events\DomainsDomainCreatedEvent;
use App\BoundedContext\Backoffice\Domains\Model\Events\DomainsDomainDeletedEvent;
use App\BoundedContext\Backoffice\Domains\Model\Events\DomainsDomainUpdatedEvent;
use App\BoundedContext\Backoffice\Shorter\Application\EventHandler\OnShorterUrlCreatedEventUpdateShortUrlHandler;
use App\BoundedContext\Backoffice\Shorter\Model\Event\ShorterUrlCreatedEvent;
use App\BoundedContext\Core\Infra\EventBus\SimpleInMemory\SimpleInMemoryEventBus;
use App\BoundedContext\Core\Model\EventBus\EventBus;
use Illuminate\Support\ServiceProvider;

class EventBusServiceProvider extends ServiceProvider
{
    /**
     * @var SimpleInMemoryEventBus
     */
    private $eventBus;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $eventBus = new SimpleInMemoryEventBus();
        $this->eventBus = $eventBus;
        $this->app->singleton(EventBus::class, function ($app) use ($eventBus) {
            return $eventBus;
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
            // shorter module
            ShorterUrlCreatedEvent::class => OnShorterUrlCreatedEventUpdateShortUrlHandler::class

        ];

        foreach ($map as $name => $handler) {
            $this->eventBus->subscribe($name, [$this->app->make($handler), 'handle']);
        }
    }
}
