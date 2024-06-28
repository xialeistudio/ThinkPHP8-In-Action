<?php
/**
 * File: ArrayHelper.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\helper;

class ArrayHelper
{
    public static function filter(array $data, array $keys)
    {
        $result = [];
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $result[$key] = $data[$key];
            }
        }

        return $result;
    }
}