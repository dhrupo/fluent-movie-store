<?php

namespace NewProject\App\Http\Controllers;

use Exception;
use NewProject\App\Http\Requests\RentalRequest;
use NewProject\App\Models\Movie;
use NewProject\Framework\Request\Request;
use NewProject\App\Models\Rental;
use NewProject\App\Http\Traits\ValidatorTrait;

class RentalController extends Controller
{
  use ValidatorTrait;

  public function index(Request $request)
  {
    $rental = Rental::with(['movie', 'user'])->get();
    return $rental;
  }

  public function store(Request $request)
  {
    $stock = Movie::where('movie_id', $request->movie_id)->value('in_stock');
    if ($stock == 0) {
      throw new Exception("Movie is out of stock", 400);
    }

    $rules = RentalRequest::$rules;
    $messages = RentalRequest::$messages;
    $this->validateData($request->all(), $rules, $messages);

    $data['movie_id'] = $request->movie_id;
    $data['user_id'] = $request->user_id;
    $data['rental_date_out'] = $request->rental_date_out;
    $data['rental_date_return'] = $request->rental_date_return;

    $addedRental = Rental::create($data);
    $update_stock = Movie::where('movie_id', $request->movie_id)->update(['in_stock' => $stock - 1]);

    if ($addedRental) {
      return [
        'status' => 200,
        'message' => __('Successfully rented the movie.'),
        'rental' => $addedRental
      ];
    } else {
      throw new Exception("Something error has happened!", 400);
    }
  }
}
