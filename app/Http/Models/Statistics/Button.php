<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 27.05.2016
 * Time: 17:23
 */

namespace Anticafe\Http\Models\Statistics;


use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    protected $table = "statistics_buttons";

    protected $guarded = [];

    public $timestamps = true;
}