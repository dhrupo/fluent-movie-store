<?php

namespace NewProject\App\Models;

use NewProject\App\Models\Model;

class Rental extends Model
{
  protected $table = 'fms_rentals';

  public function movie()
  {
    $class = __NAMESPACE__ . '\Movie';

    return $this->belongsTo($class, 'movie_id', 'movie_id');
  }

  public function user()
  {
    $class = __NAMESPACE__ . '\User';

    return $this->belongsTo($class, 'user_id', 'ID');
  }
}
