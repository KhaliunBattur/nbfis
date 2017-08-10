<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/10/2017
 * Time: 12:41 PM
 */

namespace App\Support;


use Illuminate\Database\Eloquent\Model;

class ReferenceText extends Model
{

    /**
     * @var string
     */
    protected $table = 'reference_text';

    /**
     * @var array
     */
    protected $fillable = ['text', 'type'];

}