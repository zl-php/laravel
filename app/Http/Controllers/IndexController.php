<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        //throw new InvalidRequestException('erere');

        //return new UserResource(User::findOrFail(1));

        $users = User::all();
        return new UserCollection($users);
    }
}
