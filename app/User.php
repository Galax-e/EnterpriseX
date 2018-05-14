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

use Illuminate\Pagination\LengthAwarePaginator as Paginator;

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
        return $this->hasMany('App\Member');
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
     * @return string
     */
    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
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

    public function has_org() {
        return $this->is_executive() || $this->hasRole('member');
    }

    public function user_organizations() {

        $orgs = \App\Models\Organization::with('members')->get();

        // $orgs = \App\Member::where('user_id', $this->id)->get();
        // // $vr = \DB::table('members')->where('user_id', $this->id)->get();

        // if ($this->hasRole('owner')) {
        //     $orgs['owner'] =  $this->organization;
        // }
        // return $orgs;

        $user = $this;
        $user_org = [];
        // get user organization
        if ($user->hasRole('owner')) {
            $user_org['owner'] =  $user->organization;
        }
        foreach ($orgs as $org) {
            # code...
            foreach ($org->members as $member) {
                # code...
                if ($member->user_id === $user->id) {
                    $user_org['member'] = $org;
                }
            }
        }
        return $user_org;
    }

    public function user_org_projects($org) {
        if ($org->id !== optional(auth()->user()->organization)->id ) {
            // user is not the owner of the oorganization, thus fetch the projects 
            // where user is a member.
            $projects = $org->projects;
            $member_id;
            foreach ($org->members as $member) {
                if ($member->user_id === auth()->user()->id) {
                    $member_id = $member->user_id;
                }
            }
            $temp = [];
            foreach($projects as $project) {
                foreach ($project->teams as $team) {
                    $team_member = TeamMember::where('team_id', $team->id)->where('member_id', $member_id)->first();
                    if ($team_member) {
                        $temp[] = $project;
                    }
                }
            }
            // make an instance of paginate
            $projects = new Paginator($temp, count($temp), 10);            
            // $projects = $org->projects->filter(function($value, $key) use ($temp) {
            //     foreach ($temp as $val) {
            //         return $value->id === $val->id;
            //     }
            // });
        }else{
            $projects = $org->projects()->paginate(10);
        }
        return $projects;
    }
    public function is_client($org) {
        $org_clients = optional($org->organization)->clients;
        if(! $org_clients) {
            return false;
        }

        foreach ($org_clients as $clients) {
            if ($clients->user_id === $this->id) {
                return true;
            }
        }
        return false;
    }
}
