<?php
/**
 * File: UserService.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\service;

use app\BaseObject;
use app\model\User;
use app\repository\Repository;
use Exception;
use think\Paginator;

class UserService extends BaseObject
{
    /**
     * 添加用户
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        $user = Repository::ModelFactory(User::class)->findOne(['phone' => $data['phone']]);
        if (!empty($user)) {
            throw new Exception('手机号码已存在');
        }
        return Repository::ModelFactory(User::class)->insert($data);
    }

    /**
     * 查找用户
     * @param int $userId
     * @return User
     * @throws Exception
     */
    public function findOne($userId)
    {
        $user = Repository::ModelFactory(User::class)->findOne(['user_id' => $userId]);
        if (empty($user)) {
            throw new Exception('用户不存在');
        }
        return $user;
    }

    /**
     * 编辑用户
     * @param int $userId
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function update($userId, array $data)
    {
        $user = $this->findOne($userId);
        return Repository::ModelFactory(User::class)->update($user, $data);
    }

    /**
     * 分页列表
     * @param int $size
     * @param null $keyword
     * @return Paginator
     */
    public function list($size = 10, $keyword = null)
    {
        return Repository::ModelFactory(User::class)->listBySearch($size, [], 'realname|phone', $keyword);
    }
}