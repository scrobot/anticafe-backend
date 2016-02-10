<?php

namespace Anticafe\Packages\Roles;

use Anticafe\Http\Models\User;
use Anticafe\Packages\Permissions\Permission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $fillable = [];
    
    protected $guarded = [];
    
    protected $table = 'roles';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

}
