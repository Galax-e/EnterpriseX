<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;

use Backpack\CRUD\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
// use Laravel\Passport\HasApiTokens;
use DB;
use Backpack\PermissionManager\app\Models\Role;

class User extends Authenticatable
{
    use Notifiable; //, HasApiTokens
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * A user can be a member
    */

    public function member(){
        return $this->hasOne('App\Member');
    }

    /**
     * A user can own an organization
    */
    public function organization(){
        return $this->hasOne('App\Models\Organization');
    }

    /**
     * Get the roles that belong to each user
     */
    public function roles(){
        
        // Backpack\PermissionManager\app\Models\Role, belongsToMany
        return $this->belongsToMany('Backpack\PermissionManager\app\Models\Role', 'role_users')->withTimestamps();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    
    /**
     * @return string
     */
    public function getNameAndUsernameAttribute()
    {
        return "$this->name ($this->username)";
    }

    /**
     * @return bool
     */
    public function isRootAdmin()
    {
        // Protect the root user from edits.
        if ('superadmin' == $this->username OR 'superuser' == $this->username) {
            return true;
        }
        // Otherwise
        return false;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        // Protect the root user from edits.
        if ($this->hasRole('admin')) {
            return true;
        }
        // Otherwise
        return false;
    }

    // public function getOrganization() {

    //     // checks that user is an owner
    //     if ($this->hasRole('owner')) {
    //         $org = DB::table('organizations')->where('user_id', $this->id)->first();
    //         return $org;
    //     }else{
    //         return null;
    //     }
    // }

    public function getRoles() {
        $roles = $this->roles;

        $user_roles = [];
        foreach($roles as $role) {
            $user_roles[] = $role->name;
        }
        return collect($user_roles);
    }

    public function is_executive() {
        return $this->hasRole('owner') || $this->hasRole('client');
    }
}
