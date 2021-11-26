<?php

namespace NewProject\App\Models;

use NewProject\App\Models\Model;

class Transaction extends Model
{
  protected $table = 'fms_transactions';

  public function rentals()
  {
    $class = __NAMESPACE__ . '\Rental';

    return $this->hasMany($class, 'movie_id', 'movie_id');
  }
}
