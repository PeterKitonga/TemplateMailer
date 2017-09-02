<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['role_name', 'role_slug', 'role_permissions'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user');
    }

    public function setRoleSlugAttribute($value)
    {
        $this->attributes['role_slug'] = str_replace(" ", "_", strtolower($value));
    }
}
