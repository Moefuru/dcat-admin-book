<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        //获取请求头中的token
        $token = $request->header('token');
        if (empty($token)) {
            throw new \Exception('Token不能为空');
        }

        //检测token的合法性
        $tokenInfo = Cache::get($token);
        $userInfo = json_decode($tokenInfo, true);

        if (empty($userInfo['token_expire_time'])) {
            throw new \Exception('Token已失效');
        }
        return $next($request);
    }
}
