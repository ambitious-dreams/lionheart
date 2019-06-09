<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $errors = Session::pull('errors');

        return response()->json(compact('user', 'errors'), Response::HTTP_OK);
    }
}
