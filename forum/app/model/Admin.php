<?php
/**
 * File: Admin.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\model;

use think\Model;

/**
 * 系统管理员
 * Class Admin
 * @package app\model
 * @property int $admin_id
 * @property string $username
 * @property string $password
 * @property int $created_at
 * @property int $login_at
 * @property string $login_ip
 */
class Admin extends Model
{
    protected $pk = 'admin_id';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = false;
}