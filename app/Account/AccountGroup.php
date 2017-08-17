<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/15/2017
 * Time: 2:28 PM
 */

namespace App\Account;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountGroup extends Model
{

    /**
     * @var string
     */
    protected $table = 'account_group';

    /**
     * @var array
     */
    protected $fillable = ['code', 'name', 'root_id'];

    /**
     * @return BelongsTo
     */
    public function root()
    {
        return $this->belongsTo(AccountGroup::class, 'root_id');
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(AccountGroup::class, 'root_id')->with('root');
    }

    /**
     * @return HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'group_id');
    }

}