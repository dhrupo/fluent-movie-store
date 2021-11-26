<?php

/**
 * @var $router NewProject\App\Http\Router
 */

$router->get('/welcome', 'WelcomeController@index');
$router->get('/movies', 'MovieController@index');
$router->post('/movies', 'MovieController@store');
$router->get('/movies/{id}', 'MovieController@details')->int('id');
$router->put('/movies/{id}', 'MovieController@edit')->int('id');
$router->delete('/movies/{id}', 'MovieController@delete')->int('id');

$router->get('/genres', 'GenreController@index');
$router->post('/genres', 'GenreController@store');
$router->delete('/genres/{id}', 'GenreController@delete')->int('id');

$router->get('/rentals', 'RentalController@index');
$router->post('/rentals', 'RentalController@store');

$router->get('/users', 'UserController@index');
