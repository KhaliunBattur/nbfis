<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/10/2017
 * Time: 3:53 PM
 */

namespace App\User\Expense;


use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    /**
     * @var string
     */
    protected $table = 'expense';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'expense'];

}