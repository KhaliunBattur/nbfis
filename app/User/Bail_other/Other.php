<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/9/2017
 * Time: 3:23 PM
 */

namespace App\User\Bail_other;

use Illuminate\Database\Eloquent\Model;

class Other extends model
{
    protected  $table = 'bail_other';

    protected $fillable = ['user_id','name','price','description'];
}