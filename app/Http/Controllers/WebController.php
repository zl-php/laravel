<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\InvalidRequestException;

class WebController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function ws()
    {
        return view('ws');
    }
}
