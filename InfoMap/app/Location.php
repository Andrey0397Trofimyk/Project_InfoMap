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
     * Connection with model User.
     *
     */
    public function user() {
       return  $this->belongsTo('App\User');
    }
     /**
     * Connection with model Comment.
     *
     */
	public function comments() {
		return $this->hasMany('App\Comment');
    }
     /**
     * Connection with model Image.
     *
     */
	public function images() {
		return $this->hasMany('App\Image');
	}

}
