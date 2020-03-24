<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','location_id','surname','review'
      ];

     /**
     * Connection with model User.
     *
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
     /**
     * Connection with model Location.
     *
     */
    public function location() {
        return $this->belongsTo('App\Location');
    }
}
