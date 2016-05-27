<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 27.05.2016
 * Time: 17:22
 */

namespace Anticafe\Http\Models\Statistics;


use Illuminate\Database\Eloquent\Model;

class Install extends Model
{
    protected $table = "statistics_installs";
    
    protected $guarded = [];
    
    public $timestamps = true;
}