<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller\admin;

use app\BaseController;
use app\Request;
use app\service\admin\UserService;

class User extends BaseController
{
    public function index(Request $request)
    {
        if($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        $size = $request->get('size', 10);
        try {
            $list = UserService::Factory()->list($size);
            return  view('index', ['list' => $list]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}