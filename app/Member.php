<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    public function teams(){
        return $this->belongsToMany('App\Models\Team');
    }

    public function user(){
        return $this->hasOne('App\User');
    }

}
