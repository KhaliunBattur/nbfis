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
use App\Transaction\Transaction;
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
     * @return $this
     */
    public function breakdown()
    {
        return $this->hasMany(Transaction::class, 'account_id')->whereNull('type');
    }

    /**
     * @param $breakdown
     * @param $season
     * @param $account
     */
    public function syncBreakDowns($breakdown, $season, $account)
    {
        $children = $this->breakdown;
        $items = collect($breakdown);

        $delete_ids = $children->filter(function($child) use($items){
            return empty(
                $items->where('id', $child->id)->first()
            );
        })->map(function($child) {
            $id = $child->id;
            $child->delete();

            return $id;
        });

        $attachments = $items->filter(function($item){
            return empty($item['id']);
        })->map(function($item) use ($delete_ids, $season, $account) {
            $item['id'] = $delete_ids->pop();
            $item['season_id'] = $season->getKey();
            $item['account_id'] = $account['id'];
            $item['description'] = is_null($item['description']) ? 'Эхний үлдэгдэл' : $item['description'];
            $item['exchange'] = $account['exchange'];
            $item['user_id'] = \Auth::user()->getKey();
            return new Transaction($item);
        });

        if($attachments->count() == 0)
        {
            $attachments = $items->map(function($item){
                $transaction = Transaction::find($item['id']);
                $transaction->amount = $item['amount'];
                $transaction->description = is_null($item['description']) ? 'Эхний үлдэгдэл' : $item['description'];
                return $transaction;
            });
        }

        $this->breakdown()->saveMany($attachments);
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