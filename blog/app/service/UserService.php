<?php
/**
 * File: UserService.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\service;

use app\model\User;
use Exception;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 用户业务
 */
class UserService
{
    const SESSION_KEY = 'user';

    /**
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws DataNotFoundException
     */
    public function signup($username, $password)
    {
        // 检查账号是否存在
        $user = User::where('username', $username)->find();
        if (!empty($user)) {
            throw new DbException('用户名已存在');
        }
        $user = new User();
        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->role = User::ROLE_USER;
        $user->created_ip = request()->ip();
        return $user->save();
    }

    /**
     * 登录
     * @param string $username
     * @param string $password
     * @return User|null
     * @throws DbException
     * @throws Exception
     */
    public function signin($username, $password)
    {
        $user = User::where('username', $username)->find();
        if (empty($user) || !password_verify($password, $user->password)) {
            throw new Exception('用户名或密码错误');
        }
        session(self::SESSION_KEY, $user);
        return $user;
    }

    /**
     * 修改密码
     * @param $userId
     * @param $password
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function changePassword($userId,$password)
    {
        $user = User::find($userId);
        if(empty($user)) {
            throw new Exception('用户不存在');
        }
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        return $user->save();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session(self::SESSION_KEY, null);
    }

    /**
     * 检测是否游客
     * @return bool
     */
    public function isGuest()
    {
        return !session(self::SESSION_KEY);
    }

    /**
     * 要求登录
     * @return \think\response\Redirect
     */
    public function loginRequired()
    {
        return redirect('/user/signin');
    }

    /**
     * 用户ID
     * @return mixed|null
     */
    public function userId()
    {
        $user = session(self::SESSION_KEY);
        return $user ? $user->user_id : null;
    }
}