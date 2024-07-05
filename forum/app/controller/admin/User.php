<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller\admin;

use app\BaseController;
use app\service\UserService;

class User extends BaseController
{
    public function index()
    {
        if($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        $list = UserService::Factory()->listByPageByKeyword(30,request()->get('keyword'));
        return view('index',[
            'list' => $list
        ]);
    }
}