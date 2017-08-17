<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/17/2017
 * Time: 10:24 AM
 */

namespace App\Support;


use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * @var string
     */
    protected $table = 'bank';

    /**
     * @var array
     */
    protected $fillable = ['name'];
}