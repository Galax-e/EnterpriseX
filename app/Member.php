<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{


    protected $fillable = [];
    
    //
    public function organization() {
        return $this->belongsTo('App\Models\Organization');
    }
    
    //
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function team_members(){
        return $this->hasMany('App\TeamMember');
    }


}
