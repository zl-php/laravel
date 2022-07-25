<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $time1 = LARAVEL_START;
        $response = $next($request);
        $time2 = microtime(true);

        //dd($response->headers);

        Log::channel('api_info')->info('', [
            'path'    => $request->path(),
            'method'  => $request->method(),
            'request' => $request->all(),
            'response'=> $response->getData(true),
            'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'ip'      =>  $request->ip(),
            'time'    => sprintf("%.4f",($time2-$time1)).'秒'
        ]);

        return $response;
    }
}
