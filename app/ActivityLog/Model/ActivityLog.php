<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/8/2017
 * Time: 11:43 AM
 */

namespace App\ActivityLog\Model;


use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{

    /**
     * @var string
     */
    protected $table = 'log';

    /**
     * @var array
     */
    protected $fillable = ['logged_user_id', 'user_id', 'log_type', 'log'];

}