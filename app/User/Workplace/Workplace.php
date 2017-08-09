<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/7/2017
 * Time: 3:37 PM
 */

namespace App\User\Workplace;


use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{

    /**
     * @var string
     */
    protected $table = 'workplace';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'organization', 'date_employment', 'position', 'activity', 'address', 'worker_count'];

}