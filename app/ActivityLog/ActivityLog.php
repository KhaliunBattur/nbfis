<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/8/2017
 * Time: 11:43 AM
 */

namespace App\ActivityLog;


use App\User\User;
use App\ActivityLog\Model\ActivityLog as ActivityLogModel;

class ActivityLog
{

    /**
     * @param $text
     * @param $type
     * @param User $user
     */
    public function write($text, $type, $user)
    {
        ActivityLogModel::create([
            'logged_user_id' => \Auth::user()->getKey(),
            'user_id' => $user->getKey(),
            'log_type' => $type,
            'log' => $text
        ]);
    }

}