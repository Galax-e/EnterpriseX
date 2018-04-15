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
}
