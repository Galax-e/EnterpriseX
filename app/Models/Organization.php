<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Organization extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'organizations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'address', 'city', 'state', 'country', 'phone_number', 'number_of_staff',
                            'description', 'industry'];
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

    //
    public function clients() {
        return $this->hasMany('App\Models\Client'); 
    }

    //
    public function projects() {
        return $this->hasMany('App\Models\Project'); 
    }

    //
    public function teams() {
        return $this->hasMany('App\Models\Team'); 
    }

    //
    public function members() {
        return $this->hasMany('App\Member'); 
        //, 'organization_member', 'organization_id', 'member_id')->withTimestamps();
    }

    //
    public function user() {
        return $this->belongsTo('App\User')->withDefault(); 
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

    public function setZipAttribute($value) {
        if ( !empty($value) ) { // will check for empty string, null values, see php.net about it
            $this->attributes['zip'] = $value;
        } 
    }
}
