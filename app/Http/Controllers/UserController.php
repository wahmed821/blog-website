<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Auth;
use DB;

class UserController extends Controller
{
    public function __construct()
    { }

    ## Dashboard
    public function dashboard()
    {
        //return "<h1>Hello " . Auth::user()->name . "</h1>";
        return view('user.dashboard');
    }
}
