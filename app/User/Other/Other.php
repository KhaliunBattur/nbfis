<?php

namespace App\User\Other;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    protected $table = 'bail_other';

    protected  $fillable=['user_id','name','price','description'];
}
