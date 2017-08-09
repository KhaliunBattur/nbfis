<?php

namespace App\User\Contact;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * @var string
     */
    protected $table = 'emergency_contact';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'relation', 'job', 'register', 'budged', 'phone_number'];
}
