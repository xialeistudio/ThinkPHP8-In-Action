<?php
/**
 * File: AddressService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service;

use app\model\Address;
use Exception;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 地址管理
 * Class AddressService
 * @package app\index\service
 */
class AddressService extends Service
{
    /**
     * 添加地址
     * @param array $data
     * @param int $userId
     * @return Address
     * @throws Exception
     */
    public function create(array $data, $userId)
    {
        $model = new Address();
        if ($data['default']) {
            Address::update(['default' => 0], ['user_id' => $userId]);
        }
        $model->data($data);
        $model->user_id = $userId;
        if (!$model->save()) {
            throw new Exception('添加地址失败');
        }
        return $model;
    }

    /**
     * 查看地址
     * @param int $id
     * @param int $userId
     * @return Address|null
     * @throws Exception
     * @throws DbException
     */
    public function show($id, $userId)
    {
        $model = Address::where(['id' => $id, 'user_id' => $userId])->find();
        if (empty($model)) {
            throw new Exception('地址不存在');
        }
        return $model;
    }

    /**
     * 编辑
     * @param int $id
     * @param array $data
     * @param int $userId
     * @return Address|null
     * @throws DbException
     * @throws Exception
     */
    public function update($id, array $data, $userId)
    {
        $model = $this->show($id, $userId);
        if ($data['default']) {
            Address::update(['default' => 0], ['user_id' => $userId]);
        }
        $model->data($data);
        if (!$model->save()) {
            throw new Exception('编辑失败');
        }
        return $model;
    }

    /**
     * 获取用户地址列表
     * @param int $userId
     * @return false|PDOStatement|string|Collection
     * @throws DbException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function all($userId)
    {
        return Address::where('user_id', $userId)->order(['default' => 'desc', 'id' => 'asc'])->select();
    }

    /**
     * 删除
     * @param int $id
     * @param     $userId
     * @throws Exception
     */
    public function delete($id, $userId)
    {
        if (!Address::destroy(['id' => $id, 'user_id' => $userId])) {
            throw new Exception('删除失败');
        }
    }
}