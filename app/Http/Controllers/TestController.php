<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;

class TestController extends Controller
{
    public function test()
    {
        $name = 'zhiguodu(xxxx）';

        // 1.不管有没有括号，无差别替换中文括号至英文括号
        $relname = str_replace(['（', '）'], ['(', ')'], $name);

        // 2.如果有括号，正则匹配括号里的名字
        if(preg_match_all("/(?:\()(.*)(?:\))/i",$relname, $result))
            $relname =  $result[1][0];

        echo $relname;

    }
}
