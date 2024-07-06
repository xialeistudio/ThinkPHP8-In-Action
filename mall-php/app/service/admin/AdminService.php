<?php
/**
 * File: AdminService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service\admin;

use app\service\Service;
use Exception;
use think\facade\Filesystem;
use think\File;

class AdminService extends Service
{
    /**
     * 登录
     * @param string $username
     * @param string $password
     * @throws Exception
     */
    public function login($username, $password)
    {
        $admins = config('app.params.admins');
        if (!isset($admins[$username]) || $admins[$username] != $password) {
            throw new Exception('账号或密码错误', 400);
        }
        session('admin', $username);
    }

    public function logout()
    {
        session('admin', null);
    }

    /**
     * @param File $file
     * @return string
     * @throws Exception
     */
    public function upload(File $file)
    {
        return '/storage/' . Filesystem::disk('public')->putFile('upload', $file);
    }

    /**
     * @param File[] $files
     * @return array
     * @throws Exception
     */
    public function uploadMulti(array $files)
    {
        $result = [];
        foreach ($files as $file) {
            $result[] = $this->upload($file);
        }
        return $result;
    }
}