<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Team extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'teams';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * A Team belongs to a project
    */
    public function project() {
        return $this->belongsTo('App\Model\Project'); 
    }

    /**
     * A Team has one agile board
     */
    public function agile_board(){
        
        return $this->hasOne('App\AgileBoard');
    }

    /**
     * A Team has many team members to a project
    */
    public function team_members() {
        return $this->hasMany('App\Members'); 
    }

    /**
     * A Team belongs to organization
    */
    public function organization() {
        return $this->belongsTo('App\Models\Organization'); 
    }

    /**
     * A Team has belongs to client
    */
    public function client() {
        return $this->belongsTo('App\Models\Client'); 
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
