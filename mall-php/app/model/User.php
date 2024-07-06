<?php
/**
 * File: User.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\model;

use think\Model;
/**
 * 用户
 * Class User
 * @property int    $id
 * @property string $nickname
 * @property string $avatar
 * @property string $openid
 * @property int    $created_at
 * @property string $created_ip
 */
class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;
}