<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/9/2017
 * Time: 2:29 PM
 */

namespace App\User\Car;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected  $table = 'bail_car';

    protected $fillable = ['user_id','model','color','entry_date','price'];
}