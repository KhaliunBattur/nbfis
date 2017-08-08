<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/8/2017
 * Time: 11:45 AM
 */

namespace App\ActivityLog\Provider;


use App\ActivityLog\ActivityLog;
use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('activity-log', function(){
            return new ActivityLog();
        });
    }

}