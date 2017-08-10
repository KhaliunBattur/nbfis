<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/10/2017
 * Time: 3:53 PM
 */

namespace App\User\Budget;


use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    /**
     * @var string
     */
    protected $table = 'budget';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'budget'];

}