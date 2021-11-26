<?php

namespace NewProject\App\Http\Requests;

use NewProject\Framework\Foundation\RequestGuard;

class RentalRequest extends RequestGuard
{
  public static $rules = [
    'movie_id' => 'required|unique:fms_rentals,user_id',
    'user_id' => 'required|unique:fms_rentals,movie_id',
    'rental_date_out' => 'required',
    'rental_date_return' => 'required'
  ];

  public static $messages = [
    'rental_date_out.required' => "Out date is required",
    'rental_date_return.required' => "Out date is required",
    'movie_id.unique' => 'Movie has already rented by the user',
    'movie_id.required' => 'Movie is required',
    'user_id.unique' => 'Users has already rented the movie',
    'user_id.required' => 'Users is required',
  ];
}
