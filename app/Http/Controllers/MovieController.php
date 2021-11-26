<?php

namespace NewProject\App\Http\Controllers;

use NewProject\App\Http\Requests\MovieRequest;
use NewProject\Framework\Request\Request;
use NewProject\App\Models\Movie;
use NewProject\App\Models\Rental;
use NewProject\App\Http\Traits\ValidatorTrait;

class MovieController extends Controller
{
  use ValidatorTrait;

  public function index(Request $request)
  {
    $movie = Movie::with(['genre'])->get();
    return $movie;
  }

  public function store(Request $request)
  {
    $rules = MovieRequest::$rules;
    $messages = MovieRequest::$messages;
    $this->validateData($request->all(), $rules, $messages);

    $data['movie_name'] = $request->movie_name;
    $data['director'] = $request->director;
    $data['genre_id'] = $request->genre_id;
    $data['in_stock'] = $request->in_stock;
    $data['rental_rate'] = $request->rental_rate;
    $addedMovie = Movie::create($data);

    return [
      'status' => 200,
      'message' => __('Movie has been added'),
      'movie' => $addedMovie
    ];
  }

  public function details(Request $request)
  {
    $movie_id = $request->only(['movie_id']);
    $movie = Movie::where('movie_id', $movie_id)->with(['genre'])->first();
    return $movie;
  }

  public function edit(Request $request)
  {
    $movie_id = $request->only(['movie_id']);
    $data = $request->only(['movie_name', 'director', 'genre_id']);
    $movie = Movie::where('movie_id', $movie_id)->update($data);
    return $movie;
  }

  public function delete(Request $request)
  {
    $movie_id = $request->only(['movie_id']);
    $movie = Movie::where('movie_id', $movie_id)->delete();
    $rental = Rental::where('movie_id', $movie_id)->delete();
    return $movie;
  }
}
