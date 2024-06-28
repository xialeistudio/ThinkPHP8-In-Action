<?php
/**
 * File: Bootstrap5Pagination.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app;

use think\paginator\driver\Bootstrap;

class
Bootstrap5Pagination extends Bootstrap
{
    protected function getAvailablePageWrapper(string $url, string $page): string
    {
        return '<li class="page-item"><a class="page-link" href="' . htmlentities($url) . '">' . $page . '</a></li>';
    }
    protected function getDisabledTextWrapper(string $text): string
    {
        return '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)">' . $text . '</a></li>';
    }

    /**
     * 生成一个激活的按钮.
     *
     * @param string $text
     *
     * @return string
     */
    protected function getActivePageWrapper(string $text): string
    {
        return '<li class="page-item active"><a class="page-link" href="javascript:void(0)">' . $text . '</a></li>';
    }
}