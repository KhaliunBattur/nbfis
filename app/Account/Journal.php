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

class Journal extends Model
{

    /**
     * @var string
     */
    protected $table = 'journal';

    /**
     * @var array
     */
    protected $fillable = ['name', 'form_code', 'root_id'];

    /**
     * @return BelongsTo
     */
    public function root()
    {
        return $this->belongsTo(Journal::class, 'root_id');
    }

}