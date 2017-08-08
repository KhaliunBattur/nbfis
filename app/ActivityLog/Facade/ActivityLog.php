<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/8/2017
 * Time: 11:46 AM
 */

namespace App\ActivityLog\Facade;


use Illuminate\Support\Facades\Facade;

class ActivityLog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'activity-log';
    }
}