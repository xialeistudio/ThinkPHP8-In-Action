<?php
// 控制器
namespace app\controller;

use app\BaseController;
use app\facade\Util;
use app\middleware\Auth;
use app\middleware\Log;

class Index extends BaseController
{
    protected $middleware = [Log::class, Auth::class];

    public function aaa()
    {
        sleep(1);
        return Util::foo('bbb');
    }
}
