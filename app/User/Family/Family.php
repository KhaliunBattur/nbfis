<?php

namespace App\User\Family;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

    /**
     * @var string
     */
    protected $table = 'family_members';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'relation', 'job', 'register', 'budged', 'phone_number'];
}
