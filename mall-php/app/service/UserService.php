<?php
/**
 * File: UserService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service;

use app\model\User;
use Exception;
use Firebase\JWT\JWT;
use think\db\exception\DbException;

class UserService extends Service
{
    /**
     * @param array $info
     * @return User|array|null
     * @throws Exception
     * @throws DbException
     */
    public function oauth(array $info)
    {
        $session = WechatService::Factory()->getSession($info['code']);
        $openid = $session['openid'];
        unset($info['code']);

        $user = User::get(['openid' => $openid]);
        if (empty($user)) {
            $user = new User();
            $user->openid = $openid;
        }

        $user->nickname = $info['nickname'];
        $user->avatar = $info['avatar'];

        if (false === $user->save()) {
            throw new Exception('授权失败');
        }
        $user = $user->toArray();
        $user['token'] = JWT::encode([
            'user_id' => $user['id'],
            'expired_at' => time() + config('app.params.jwt.ttl')
        ], config('app.params.jwt.key'), 'HS256');
        return $user;
    }
}