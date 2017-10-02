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
        \Validator::extend('greater_than_zero', function($attribute, $value, $parameters, $validator) {
            return $value > 0;
        });
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
        $this->app->singleton('App\Season\SeasonRepositoryInterface', 'App\Season\SeasonRepository');
        $this->app->singleton('App\User\LoanRequest\RequestRepositoryInterface','App\User\RequestRepository');
        $this->app->singleton('App\Transaction\TransactionRepositoryInterface','App\Transaction\TransactionRepository');
        $this->app->singleton('App\Transaction\ReceivableRepositoryInterface','App\Transaction\ReceivableRepository');
        $this->app->singleton('App\Branch\BranchRepositoryInterface','App\Branch\BranchRepository');
        $this->app->singleton('App\Apartment\ApartRepositoryInterface','App\Apartment\ApartRepository');
        $this->app->singleton('App\Car\CarRepositoryInterface','App\Car\CarRepository');
        $this->app->singleton('App\Other\OtherRepositoryInterface','App\Other\OtherRepository');
    }
}
