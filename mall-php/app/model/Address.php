<?php
/**
 * File: Address.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\model;

use think\Model;

/**
 * 收货地址
 * Class Address
 * @property int $id
 * @property string $realname
 * @property string $phone
 * @property string $address
 * @property bool $default
 * @property int $user_id
 */
class Address extends Model
{
    protected $type = [
        'default' => 'boolean'
    ];
}