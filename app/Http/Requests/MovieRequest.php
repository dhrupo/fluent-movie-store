<?php

namespace NewProject\App\Http\Requests;

use NewProject\Framework\Foundation\RequestGuard;

class MovieRequest extends RequestGuard
{
  public static $rules = [
    'movie_name' => 'required',
    'director' => 'required',
    'in_stock' => 'required',
    'rental_rate' => 'required'
  ];

  public static $messages = [
    'movie_name.required' => "Movie name is required",
    'director.required' => "Director name is required",
    'in_stock.required' => "Movie in stock is required",
    'rental_rate.required' => "Movie rental rate is required",
  ];
}
