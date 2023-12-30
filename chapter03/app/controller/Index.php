<?php

namespace app\controller;

use app\BaseController;
use think\facade\Config;
use think\facade\Env;

class Index extends BaseController
{
    public function index()
    {
        return Env::get('SMS_CHANNEL');
    }
}
