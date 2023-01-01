<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ModifyAuthRequestHeader
{
    const AUTH_HEADER = 'Authorization';
    const TOKEN_PREFIX_BEFORE = 'Token';
    const TOKEN_PREFIX_AFTER = 'Bearer';
    /**
     * Authorizationヘッダを加工するミドルウェア(認証前に必要なためグローバル登録)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->headers->get(self::AUTH_HEADER);
        // 元から'Bearer'で送られてきたトークンは破棄
        if (strpos($authHeader, self::TOKEN_PREFIX_AFTER) === 0) {
            // 'Token'を削除
            $token = ltrim($authHeader, self::TOKEN_PREFIX_BEFORE);
            // 先頭に'Bearer'を追加
            $authHeader = strtr($authHeader, [self::TOKEN_PREFIX_BEFORE => self::TOKEN_PREFIX_AFTER]);
            $request->headers->remove(self::AUTH_HEADER);
        }

        // 'Token'を'Bearer'に変更
        if (strpos($authHeader, self::TOKEN_PREFIX_BEFORE) === 0) {
            // 'Token'を削除
            $token = ltrim($authHeader, self::TOKEN_PREFIX_BEFORE);
            // 先頭に'Bearer'を追加
            $authHeader = strtr($authHeader, [self::TOKEN_PREFIX_BEFORE => self::TOKEN_PREFIX_AFTER]);
            $request->headers->set(self::AUTH_HEADER, self::TOKEN_PREFIX_AFTER . $token);
        }
        return $next($request);
    }
}
