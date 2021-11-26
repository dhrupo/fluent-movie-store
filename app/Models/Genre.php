<?php

namespace NewProject\App\Models;

use NewProject\App\Models\Model;

class Genre extends Model
{
  protected $table = 'fms_genres';

  public function movies()
  {
    $class = __NAMESPACE__ . '\Movie';

    return $this->hasMany($class, 'genre_id', 'movie_id');
  }
}
