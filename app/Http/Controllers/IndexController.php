<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        //throw new InvalidRequestException('参数不能为空');

        return new UserResource(User::findOrFail(1));

        $users = User::all();
        return new UserCollection(User::paginate());
    }
}
