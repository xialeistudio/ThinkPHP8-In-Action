<?php
/**
 * File: AdminRepository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\repository;

use app\model\Admin;
use app\service\Repository;

class AdminRepository extends Repository
{

    protected function modelClass()
    {
        return Admin::class;
    }
}