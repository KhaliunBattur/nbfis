<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 3:40 PM
 */

namespace App\Account;


use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{

    /**
     * @var string
     */
    protected $table = 'journal';

    /**
     * @var array
     */
    protected $fillable = ['name'];

}