<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\User\UserRepositoryInterface', 'App\User\UserRepository');
        $this->app->singleton('App\User\RoleRepositoryInterface', 'App\User\RoleRepository');
        $this->app->singleton('App\User\PermissionRepositoryInterface', 'App\User\PermissionRepository');
        $this->app->singleton('App\User\Workplace\WorkplaceRepositoryInterface', 'App\User\Workplace\WorkplaceRepository');
        $this->app->singleton('App\User\Contact\ContactRepositoryInterface', 'App\User\Contact\ContactRepository');
        $this->app->singleton('App\User\Family\FamilyRepositoryInterface', 'App\User\Family\FamilyRepository');
        $this->app->singleton('App\User\Credit\CreditRepositoryInterface', 'App\User\Credit\CreditRepository');
        $this->app->singleton('App\User\Budget\BudgetRepositoryInterface', 'App\User\Budget\BudgetRepository');
        $this->app->singleton('App\User\Expense\ExpenseRepositoryInterface', 'App\User\Expense\ExpenseRepository');
        $this->app->singleton('App\User\Asset\AssetRepositoryInterface', 'App\User\Asset\AssetRepository');
        $this->app->singleton('App\Account\AccountGroupRepositoryInterface', 'App\Account\AccountGroupRepository');
        $this->app->singleton('App\Account\AccountRepositoryInterface', 'App\Account\AccountRepository');
        $this->app->singleton('App\Account\JournalRepositoryInterface', 'App\Account\JournalRepository');
        $this->app->singleton('App\Support\CurrencyRepositoryInterface', 'App\Support\CurrencyRepository');
        $this->app->singleton('App\Support\BankRepositoryInterface', 'App\Support\BankRepository');
    }
}
