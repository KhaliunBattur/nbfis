<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/11/2017
 * Time: 4:33 PM
 */

namespace App\Transaction;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Property extends Model
{

    /**
     * @var string
     */
    protected $table = 'property';

    /**
     * @var array
     */
    protected $fillable = ['account_id', 'branch_id', 'code', 'name', 'owner_id', 'unit_amount', 'count', 'start_date', 'use_time_count'];

    /**
     * @var array
     */
    protected $appends = ['show', 'showTransaction'];

    /**
     * @return bool
     */
    public function getShowAttribute()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getShowTransactionAttribute()
    {
        if($this->transactions()->count() > 1)
        {
            return true;
        }

        if($this->transactions()->count() > 0 && $this->transactions[0]->otherTransactions()->count() > 1)
        {
            return true;
        }

        return false;
    }

    /**
     * @return MorphOne
     */
    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionAble');
    }

    /**
     * @return MorphMany
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionAble', 'transaction_able', 'transaction_able_id')->with('account', 'otherTransactions', 'user', 'account.currency');
    }

}