<?php
/**
 * File: UploadService.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\service;

use app\BaseObject;
use Exception;
use think\facade\Filesystem;
use think\File;

class UploadService extends BaseObject
{
    /**
     * 上传
     * @param File $file
     * @return string
     * @throws Exception
     */
    public function upload(File $file)
    {
        return '/storage/' . Filesystem::disk('public')->putFile('topic', $file);
    }
}