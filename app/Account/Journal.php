<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 3:40 PM
 */

namespace App\Account;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journal extends Model
{

    /**
     * @var string
     */
    protected $table = 'journal';

    /**
     * @var array
     */
    protected $fillable = ['name', 'form_code', 'form_code_transaction', 'root_id'];

    /**
     * @return BelongsTo
     */
    public function root()
    {
        return $this->belongsTo(Journal::class, 'root_id');
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Journal::class, 'root_id');
    }

    /**
     * @return HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'journal_id');
    }

}