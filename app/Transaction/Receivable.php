<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/31/2017
 * Time: 2:59 PM
 */

namespace App\Transaction;


use App\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Receivable extends Model
{

    /**
     * @var string
     */
    protected $table = 'receivable';

    /**
     * @var array
     */
    protected $fillable = ['customer_id', 'start_date', 'closing_date', 'is_closed'];

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
        return $this->morphOne(Transaction::class, 'transactionAble', 'transaction_able', 'transaction_able_id');
    }

    /**
     * @return MorphMany
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionAble', 'transaction_able', 'transaction_able_id')->with('account', 'otherTransactions', 'user');
    }

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}