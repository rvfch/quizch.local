<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SpaController extends Controller
{

  public function __construct()
  {

  }

  public function index()
  {
    return view('spa');
  }
}
