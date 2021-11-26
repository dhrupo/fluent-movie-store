<?php

namespace NewProject\App\Http\Controllers;

use Exception;
use NewProject\Framework\Request\Request;
use NewProject\App\Models\Genre;

class GenreController extends Controller
{
  public function index(Request $request)
  {
    $genre = Genre::get();
    return $genre;
  }

  public function store(Request $request)
  {
    $this->validate($request->all(), [
      'genre_name' => 'required',
    ]);

    $data['genre_name'] = $request->genre_name;
    $addedGenre = Genre::create($data);

    return [
      'status' => 200,
      'message' => __('Genre has been added'),
      'genre' => $addedGenre
    ];
  }

  public function delete(Request $request)
  {
    try {
      $genre_id = $request->only(['genre_id']);
      $deletedGenre = genre::where('genre_id', $genre_id)->delete();
      if ($deletedGenre) {
        return [
          'status' => 200,
          'message' => __('Genre has been deleted'),
          'genre' => $deletedGenre
        ];
      } else {
        return [
          'status' => 500,
          'message' => __('Something Error happened'),
        ];
      }
    } catch (Exception $ex) {
      return [
        'status' => 500,
        'message' => __($ex->message),
      ];
    }
  }
}
