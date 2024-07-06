<?php
/**
 * File: UserServie.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service\admin;

use app\model\User;
use app\service\Service;
use think\db\exception\DbException;
use think\Paginator;

class UserService extends Service
{
    /**
     * 用户列表
     * @param int $size
     * @return Paginator
     * @throws DbException
     */
    public function list($size = 10)
    {
        $model = User::query();
        $model->order(['id' => 'desc']);
        return $model->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }
}