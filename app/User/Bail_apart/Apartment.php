<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 9/8/2017
 * Time: 5:04 PM
 */

namespace App\User\Bail_apart;


use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{

    /**
     * @var string
     */
    protected $table = 'bail_apart';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'address', 'apart_meter','rooms','price'];

}