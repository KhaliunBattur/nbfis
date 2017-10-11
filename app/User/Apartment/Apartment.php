<?php


namespace App\User\Apartment;


use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{

    /**
     * @var string
     */
    protected $table = 'bail_apartment';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'commissioned','address', 'apart_meter', 'room', 'price'];

}
