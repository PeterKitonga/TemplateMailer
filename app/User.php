<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_image', 'activation_status', 'activation_code',  'login_status', 'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function activated()
    {
        $this->activation_status = 1;
        $this->activation_code = null;
        $this->save();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function mailTemplates()
    {
        return $this->hasMany(MailTemplate::class);
    }

    public function mailSchedules()
    {
        return $this->hasMany(MailSchedule::class);
    }

    public function mailLogs()
    {
        return $this->hasMany(MailLog::class);
    }

    public function mailRecipient()
    {
        return $this->hasMany(MailRecipient::class);
    }

    /**
     * Checks if User has access to $permissions.
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     * @param string $roleSlug
     * @return bool
     */
    public function inRole(string $roleSlug)
    {
        return $this->roles()->getQuery()->where('role_slug', $roleSlug)->count() == 1;
    }
}
