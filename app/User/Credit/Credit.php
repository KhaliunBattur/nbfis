<?php

namespace App\User\Credit;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $table = 'active_loan_info';

    protected  $fillable = ['user_id','organization','loan_amount','loan_usage'
                    ,'loan_date','loan_interest','loan_balance','monthly_pay'];

}
