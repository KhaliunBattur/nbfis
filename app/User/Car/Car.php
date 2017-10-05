<?php

namespace App\User\Car;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    /**
     * @var string
     */
    protected $table = 'bail_car';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'model','color', 'manufacture', 'entry_date', 'price'];

}
