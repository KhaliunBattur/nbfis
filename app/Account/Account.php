<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 10:50 AM
 */

namespace App\Account;


use App\Support\Bank;
use App\Support\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{

    /**
     * @var string
     */
    protected $table = 'account';

    /**
     * @var array
     */
    protected $fillable = ['group_id', 'code', 'account_number', 'name', 'currency_id', 'journal_id', 'type', 'is_temporary', 'bank_id', 'bank_account_number'];

    /**
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(AccountGroup::class, 'group_id');
    }

    /**
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * @return BelongsTo
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    /**
     * @return BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

}