<?php

namespace NewProject\App\Hooks\Handlers;

use NewProject\App\Models\Movie;

class Shortcode
{
  function __construct()
  {
    wp_enqueue_style('fluent_movie_frontend_style', trailingslashit(plugins_url()) . 'new-project/assets/frontend/css/frontend.css');
    // wp_enqueue_script('jquery');
    wp_enqueue_script('fluent_movie_frontend_script', trailingslashit(plugins_url()) . 'new-project/assets/frontend/js/frontend.js', array('jquery'), false, true);
    // $this->renderShortcode();
  }

  function renderShortcode($atts = [], $content = '')
  {
    $movies = Movie::with(['genre'])->get();
    $c = "";

    $c .= "<div class='fluent-movie-container'>";
    $c .= "<a class='btn-add-movie'>Add Movie</a>";
    $c .= "<div class='fluent-movie-list'>";
    foreach ($movies as $item) {
      $c .= "<div class='fluent-movie-single'>";
      $c .= "<h3><a>$item->movie_name</a></h3>";
      $c .= "<h6>$item->director</h6>";
      $genre = $item->genre;
      $c .= "<p>$genre->genre_name</p>";
      $c .= "</div>";
    }
    $c .= "</div>";
    return $c;
  }
}
