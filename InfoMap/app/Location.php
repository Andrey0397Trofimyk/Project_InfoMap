<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','title','text','marker'
      ];
      
    /**
     *  Connection
     */
    public function user() {
       return  $this->belongsTo('App\User');
	}
	public function comments() {
		return $this->hasMany('App\Comment');
	}
	public function images() {
		return $this->hasMany('App\Image');
	}

}
