<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/22/2017
 * Time: 11:02 AM
 */

namespace App\User\LoanRequest;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{

    /**
     * @var string
     */
    protected $table = 'loan_request';

    /**
     * @var array
     */
    protected $fillable = ['user_id','pledge_type', 'loan_term', 'period_time',
        'payment_day', 'loan_able', 'loanable_id','pledge_type','pledge_type_id',
        'description'];

}