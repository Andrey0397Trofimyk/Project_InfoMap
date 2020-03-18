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
     * Connection
     */

    public function user() {
        return $this->belongsTo('App\User');
    }
    public function location() {
        return $this->belongsTo('App\Location');
    }
}
