<?php

namespace App\User\Family;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

    protected $table = 'family_members';
    protected $fillable =['user_id','first_name','last_name','relation','job','register','monthBudged','phone'];
}
