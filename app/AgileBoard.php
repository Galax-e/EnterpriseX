<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgileBoard extends Model
{
    //
    protected $fillable = ['description'];

    /**
     * An agile board belongs to a team
    */
    public function team() {
        return $this->belongsTo('App\Models\Team'); 
    }

}
