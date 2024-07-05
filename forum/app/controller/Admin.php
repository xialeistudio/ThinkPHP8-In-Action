<?php
/**
 * File: Admin.php
 * User: xialeistudio
 * Date: 2024/7/3
 **/

namespace app\controller;

use app\BaseController;
use app\service\AdminService;

class Admin extends BaseController
{
    public function index()
    {
        if ($this->adminId() == 0) {
            return $this->adminLoginRequired();
        }
        return view('index');
    }
}