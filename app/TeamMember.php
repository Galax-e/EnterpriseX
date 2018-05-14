<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    //
    protected $fillable = [];

    /**
     * A team member belongs to a team
    */
    public function team() {
        return $this->belongsTo('App\Models\Team'); 
    }

    /**
     * A team member is a member
    */
    public function member() {
        return $this->belongsTo('App\Member'); 
    }

     /**
     * A team member can create a task
    */
    public function issues() {
        return $this->hasMany('App\Member', 'created_by'); 
    }

    /**
     * A team member can raise an issue
    */
    public function tasks() {
        return $this->hasMany('App\Member', 'created_by'); 
    }
}
