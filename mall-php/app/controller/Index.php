<?php
/**
 * File: Index.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return json([
            'url' => request()->domain()
        ]);
    }
}