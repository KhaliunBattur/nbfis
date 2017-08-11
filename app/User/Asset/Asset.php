<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/10/2017
 * Time: 3:53 PM
 */

namespace App\User\Asset;


use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{

    /**
     * @var string
     */
    protected $table = 'asset';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'asset'];

}