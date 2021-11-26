<?php

namespace NewProject\App\Models;

use NewProject\App\Models\Model;

class Movie extends Model
{
  protected $table = 'fms_movies';

  public function genre()
  {
    $class = __NAMESPACE__ . '\Genre';

    return $this->belongsTo($class, 'genre_id', 'genre_id');
  }

  public function rental()
  {
    $class = __NAMESPACE__ . '\Genre';

    return $this->belongsTo($class, 'genre_id', 'genre_id');
  }
}
