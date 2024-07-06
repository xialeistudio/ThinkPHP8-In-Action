<?php
/**
 * File: Index.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller\admin;

use app\BaseController;
use app\service\admin\AdminService;

class Index extends BaseController
{
    public function index()
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        return redirect('/admin.goods/index');
    }

    public function logout()
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        AdminService::Factory()->logout();
        return redirect('/admin.auth/login');
    }
}