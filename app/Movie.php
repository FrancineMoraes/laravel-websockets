<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'description', 'image'
    ];
  
    public function user()
    {
      return $this->belongsTo('App\User');
    }
  
    public function comments()
    {
      return $this->hasMany('App\Comment');
    }
}
