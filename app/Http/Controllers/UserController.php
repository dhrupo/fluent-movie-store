<?php

namespace NewProject\App\Http\Controllers;

use NewProject\Framework\Request\Request;
use NewProject\App\Models\User;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $user = User::get();
    return $user;
  }
}
