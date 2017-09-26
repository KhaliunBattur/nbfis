<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/8/2017
 * Time: 5:04 PM
 */

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
    protected $fillable = ['user_id', 'address', 'apart_meter','rooms','price'];

}