<?php

namespace Helpers\Roles;

use Anticafe\Http\Models\User;
use Helpers\Permissions\Permission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $fillable = [];
    
    protected $guarded = [];
    
    protected $table = 'roles';

    public $timestamps = false;

    public function Users()
    {
        return $this->belongsToMany(User::class);
    }

    public function Permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

}
