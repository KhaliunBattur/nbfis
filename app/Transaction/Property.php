<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/11/2017
 * Time: 4:33 PM
 */

namespace App\Transaction;


use Illuminate\Database\Eloquent\Model;
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
    protected $fillable = ['group_id', 'branch_id', 'code', 'name', 'owner_id', 'unit_amount', 'count', 'start_date', 'use_time_count'];

    /**
     * @return MorphOne
     */
    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionAble');
    }

}