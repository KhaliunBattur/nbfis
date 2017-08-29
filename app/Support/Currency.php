<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 1:58 PM
 */

namespace App\Support;


use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    /**
     * @var string
     */
    protected $table = 'currency';

    /**
     * @var array
     */
    protected $fillable = ['name', 'exchange', 'marker', 'is_current'];

}