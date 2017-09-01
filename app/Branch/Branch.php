<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/1/2017
 * Time: 11:21 AM
 */

namespace App\Branch;


use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    /**
     * @var string
     */
    protected $table = 'branch';

    /**
     * @var array
     */
    protected $fillable = ['code', 'name', 'root_id'];

}