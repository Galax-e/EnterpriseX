<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    //

    protected $fillable = ['description'];
    protected $touches = ['task']; // child updates parent timestamp

    /**
     * An agile board belongs to a team
    */
    public function team() {
        return $this->belongsTo('App\Models\Team'); 
    }

    public function task() {
        return $this->belongsTo('App\Task');
    }

    public function team_member() {
        return $this->belongsTo('App\TeamMember', 'created_by');
    }

}
