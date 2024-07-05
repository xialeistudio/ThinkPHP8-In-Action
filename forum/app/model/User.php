<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;

/**
 * Class User
 * @package app\model
 * @property int $user_id
 * @property string $username
 * @property string $password
 * @property string $nickname
 * @property string $avatar
 * @property int $thread_count
 * @property int $score
 * @property int $status
 * @property int $created_at
 * @property string $created_ip
 * @property int $login_at
 * @property string $login_ip
 */
class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime         = 'created_at';
    protected $updateTime         = false;

    const STATUS_ALLOW_LOGIN = 1 << 0; // 允许登录

    /**
     * 是否允许登录
     * @return int
     */
    public function isAllowLogin()
    {
        return $this->status & self::STATUS_ALLOW_LOGIN;
    }

    /**
     * 设置是否允许登录
     * @param bool $allow
     */
    public function setAllowLogin($allow)
    {
        $this->status |= self::STATUS_ALLOW_LOGIN;
        if (!$allow) {
            // 不允许则将该位置0
            $this->status ^= self::STATUS_ALLOW_LOGIN;
        }
    }
}