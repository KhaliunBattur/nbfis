<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/31/2017
 * Time: 2:59 PM
 */

namespace App\Transaction;


use Illuminate\Database\Eloquent\Model;
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
    protected $fillable = ['customer_id', 'closing_date'];

    /**
     * @return MorphOne
     */
    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionAble');
    }

}