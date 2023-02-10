<?php

namespace App\Providers;

use App\BoundedContext\Backoffice\Dashboard\Application\Command\CreateDashboardDomainCommand;
use App\BoundedContext\Backoffice\Dashboard\Application\Command\DeleteDashboardDomainCommand;
use App\BoundedContext\Backoffice\Dashboard\Application\Command\UpdateDashboardDomainCommand;
use App\BoundedContext\Backoffice\Dashboard\Application\Command\UpdateDashboardStatsCommand;
use App\BoundedContext\Backoffice\Dashboard\Application\CommandHandlers\CreateDashboardDomainCommandHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\CommandHandlers\DeleteDashboardDomainCommandHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\CommandHandlers\UpdateDashboardDomainCommandHandler;
use App\BoundedContext\Backoffice\Dashboard\Application\CommandHandlers\UpdateDashboardStatsCommandHandler;
use App\BoundedContext\Backoffice\Domains\Application\CommandHandlers\CreateDomainsDomainCommandHandler;
use App\BoundedContext\Backoffice\Domains\Application\CommandHandlers\DeleteDomainsDomainCommandHandler;
use App\BoundedContext\Backoffice\Domains\Application\CommandHandlers\UpdateDomainsDomainCommandHandler;
use App\BoundedContext\Backoffice\Domains\Application\Commands\CreateDomainsDomainCommand;
use App\BoundedContext\Backoffice\Domains\Application\Commands\DeleteDomainsDomainCommand;
use App\BoundedContext\Backoffice\Domains\Application\Commands\UpdateDomainsDomainCommand;
use App\BoundedContext\Backoffice\Settings\Application\CommandHandlers\UpdateSettingsSettingCommandHandler;
use App\BoundedContext\Backoffice\Settings\Application\Commands\UpdateSettingsSettingCommand;
use App\BoundedContext\Backoffice\Shorter\Application\Command\CreateShorterUrlCommand;
use App\BoundedContext\Backoffice\Shorter\Application\CommandHandler\CreateShorterUrlCommandHandler;
use App\BoundedContext\Core\Infra\CommandBus\SimpleInMemory\SimpleInMemoryCommandBus;
use App\BoundedContext\Core\Model\CommandBus\CommandBus;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{

    /**
     * @var SimpleInMemoryCommandBus
     */
    private $commandBus;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $commandBus = new SimpleInMemoryCommandBus();
        $this->commandBus = $commandBus;
        $this->app->singleton(CommandBus::class, function ($app) use ($commandBus) {
            return $commandBus;
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
            CreateShorterUrlCommand::class => CreateShorterUrlCommandHandler::class

        ];

        foreach ($map as $name => $handler) {
            $this->commandBus->addHandler($name, [$this->app->make($handler), 'handle']);
        }

    }
}
