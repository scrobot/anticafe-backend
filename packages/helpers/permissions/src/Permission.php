<?php

namespace Helpers\Permissions;

use Illuminate\Database\Eloquent\Model;
use Stringy\StaticStringy;

class Permission extends Model {

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [];
    
    protected $guarded = [];
    
    protected $table = 'permissions';

    protected $casts = [
        'module' => 'array',
    ];

    public function roles()
    {
        return $this->belongsToMany('Anticafe\Packages\Roles\Role');
    }
}
