<?php

namespace Helpers\Permissions;

use Helpers\Roles\Role;
use Illuminate\Database\Eloquent\Model;
use Stringy\StaticStringy;

class Permission extends Model {

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [];
    
    protected $guarded = [];
    
    protected $table = 'permissions';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
