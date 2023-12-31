<?php
// 认证中间件
namespace app\middleware;

use app\Request;

class Auth
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->param('name') != 'admin') {
            return response('无权访问', 403);
        }

        return $next($request);
    }
}