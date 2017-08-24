<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 10:50 AM
 */

namespace App\Account;


use App\Season\Season;
use App\Support\Bank;
use App\Support\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;

class Account extends Model
{

    use PresentableTrait;

    /**
     * @var string
     */
    protected $presenter = 'App\Account\AccountPresenter';

        /**
     * @var string
     */
    protected $table = 'account';

    /**
     * @var array
     */
    protected $fillable = ['group_id', 'code', 'account_number', 'name', 'currency_id', 'journal_id', 'type', 'is_temporary', 'bank_id', 'bank_account_number'];

    /**
     * @return $this
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'season_balance', 'account_id', 'season_id')->withPivot('exchange', 'balance');
    }

    /**
     * @param $season_id
     * @return int|mixed
     */
    public function balance($season_id)
    {
        return $this->seasons()->count() ? $this->seasons()->where('season_id', $season_id)->sum('balance') : 0;
    }

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