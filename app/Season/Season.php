<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/22/2017
 * Time: 11:33 AM
 */

namespace App\Season;


use App\Account\Account;
use App\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Season extends Model
{

    /**
     * @var string
     */
    protected $table = 'season';

    /**
     * @var array
     */
    protected $fillable = ['name', 'open_user_id', 'close_user_id', 'open_date', 'close_date'];

    /**
     * @return BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'season_balance', 'season_id', 'account_id')->withPivot('exchange', 'balance');
    }

    /**
     * @return BelongsTo
     */
    public function openUser()
    {
        return $this->belongsTo(User::class, 'open_user_id');
    }

    /**
     * @return BelongsTo
     */
    public function closeUser()
    {
        return $this->belongsTo(User::class, 'close_user_id');
    }

}