<?php
// 日志中间件
namespace app\middleware;

use app\Request;

class Log
{
    public function handle(Request $request, \Closure $next)
    {
        $startAt = microtime(true);
        $resp = $next($request);
        echo '处理耗时:' . (microtime(true) - $startAt) . '秒<br>';
        return $resp;
    }
}