<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/29/2017
 * Time: 4:38 PM
 */

namespace App\Transaction;


use App\Account\Account;
use App\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    protected $fillable = ['season_id', 'transaction_number', 'receipt_number', 'transaction_date', 'customer_id', 'account_id', 'to_account_id', 'description', 'amount', 'exchange', 'type', 'transaction_able', 'transaction_able_id', 'user_id'];

    /**
     * @return MorphTo
     */
    public function transactionAble()
    {
        return $this->morphTo('transactionAble', 'transaction_able', 'transaction_able_id');
    }

    /**
     * @return HasMany
     */
    public function otherTransactions()
    {
        return $this->hasMany(Transaction::class, 'transaction_number', 'transaction_number')->with('account', 'user', 'account.currency');
    }

    /**
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return BelongsTo
     */
    public function toAccount()
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}