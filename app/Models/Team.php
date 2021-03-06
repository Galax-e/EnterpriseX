<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;

class Team extends Model
{
    use CrudTrait, RevisionableTrait;

    // If you are using another bootable trait the be sure to override the boot method in your model
    public static function boot()
    {
        parent::boot();
    }

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
    // public function task_boards(){
        
    //     return $this->hasOne('App\Task');
    // }

    /**
     * A Team has one issue board
     */
    // public function issue_boards(){
        
    //     return $this->hasOne('App\Task');
    // }

    /**
     * A Team has many tasks
     */
    public function tasks(){
        
        return $this->hasMany('App\Task');
    }

    /**
     * A Team has many issues
     */
    public function issues(){
        
        return $this->hasMany('App\Issue');
    }

    /**
     * A Team has many team members to a project
    */
    public function team_members() {
        return $this->hasMany('App\TeamMember'); 
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
