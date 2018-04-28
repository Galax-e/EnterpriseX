<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    //

    protected $fillable = ['description'];
    protected $touches = ['issue'];

    /**
     * An agile board belongs to a team
    */
    public function team() {
        return $this->belongsTo('App\Models\Team'); 
    }

    public function task() {
        return $this->belongsTo('App\Task');
    }
}
