<?php

namespace App\User;

use App\User\Asset\Asset;
use App\User\Budget\Budget;
use App\User\Contact\Contact;
use App\User\Credit\Credit;
use App\User\Expense\Expense;
use App\User\Family\Family;
use App\User\LoanRequest\Request;
use App\User\Workplace\Workplace;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'name', 'image', 'phone_number', 'address', 'live_year', 'owner_type', 'email', 'user_type', 'register', 'password','bail_info','profession'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return HasMany
     */
    public function family()
    {
        return $this->hasMany(Family::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function workplaces()
    {
        return $this->hasMany(Workplace::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function emergencies()
    {
        return $this->hasMany(Contact::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function activeLoans()
    {
        return $this->hasMany(Credit::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function budgets()
    {
        return $this->hasMany(Budget::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function assets()
    {
        return $this->hasMany(Asset::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function Request()
    {
        return $this->hasMany(Request::class,'user_id');
    }

    /**
     * @return HasMany
     */
    public function Apartment()
    {
        return $this->hasMany(Request::class,'user_id');
    }

    /**
     * @return HasMany
     */
    public function Car()
    {
        return $this->hasMany(Request::class,'user_id');
    }

    public function Other()
    {
        return $this->hasMany(Request::class,'user_id');
    }

    public function credit()
    {
        return $this->hasMany(Request::class,'user_id');
    }
}
