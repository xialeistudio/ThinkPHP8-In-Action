<?php
declare (strict_types=1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property integer $role
 * @property integer $created_at
 * @property integer $created_ip
 */
class User extends Model
{
    const ROLE_ADMIN = 0; // 超级管理员
    const ROLE_USER = 1; // 普通用户

    const STATUS_APPLY = 1;
    const STATUS_NORMAL = 2;
    const STATUS_REJECT = 3;

    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;

    protected $pk = 'user_id';
}
