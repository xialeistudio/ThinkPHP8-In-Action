<?php

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\PostService;

class Index
{
    public function index(PostService $service, Request $request)
    {
        $list = $service->list(10, $request->get('category_id'), $request->get('uid'));
        return view('index', [
            'list' => $list,
            'page' => $list->render()
        ]);
    }
}
