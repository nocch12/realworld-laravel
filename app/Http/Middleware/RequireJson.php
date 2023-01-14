<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireJson
{
    /**
     * 強制的にJSONをリクエスト
     * リクエストヘッダに Accept: application/json を付与する
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // リクエストヘッダに Accept:application/json を加える
        $request->headers->set('Accept','application/json');

        $response = $next($request);

        return $response;
    }
}
