<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
    'body', 'user_id', 'movie_id'
  ];

  public function post()
  {
    return $this->belongsTo('App\Post');
  }

  public function movie()
  {
    return $this->belongsTo('App\Movie');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
