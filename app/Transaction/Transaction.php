<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/29/2017
 * Time: 4:38 PM
 */

namespace App\Transaction;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{

    /**
     * @var string
     */
    protected $table = 'transaction';

    /**
     * @var array
     */
    protected $fillable = ['season_id', 'receipt_number', 'transaction_date', 'customer_id', 'account_id', 'to_account_id', 'description', 'amount', 'exchange', 'type', 'transaction_able', 'transaction_able_id', 'user_id'];

    /**
     * @return MorphTo
     */
    public function transactionAble()
    {
        return $this->morphTo('transactionAble', 'transaction_able', 'transaction_able_id');
    }

}