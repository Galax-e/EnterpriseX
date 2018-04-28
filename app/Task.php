<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ['description'];
    protected $touches = ['issue'];

    /**
     * An task belongs to a team
    */
    public function team() {
        return $this->belongsTo('App\Models\Team'); 
    }

    public function issue() {
        return $this->hasOne('App\Issue');
    }

}
