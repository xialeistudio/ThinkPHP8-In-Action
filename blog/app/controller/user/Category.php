<?php
/**
 * File: Category.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\controller\user;

use app\BaseController;
use app\service\CategoryService;
use app\service\UserService;
use think\exception\ValidateException;

class Category extends BaseController
{
    public function create(UserService $service, CategoryService $categoryService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'name|标题' => 'require|max:100',
                    'status|状态' => 'require|in:0,1',
                ]);
                $categoryService->create($service->userId(), $data);
                $callback = request()->get('callback');
                $callback = $callback ?: '/user.category/';
                return redirect($callback);
            } catch (ValidateException $e) {
                return view('create', [
                    'title' => '添加分类',
                    'error' => $e->getError()
                ]);
            }
        }
        return view('create', [
            'title' => '添加分类'
        ]);
    }

    public function edit(UserService $service, CategoryService $categoryService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        $id = request()->get('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $userId = $service->userId();
        $category = $categoryService->getById($id, $userId);
        if (request()->isPost()) {
            $data = request()->post();
            try {
                $this->validate($data, [
                    'name|标题' => 'require|max:100',
                    'status|状态' => 'require|in:0,1',
                ]);
                $categoryService->update($id, $userId, $data);
                $callback = request()->get('callback');
                $callback = $callback ?: '/user.category/';
                return redirect($callback);
            } catch (ValidateException $e) {
                return view('edit', [
                    'title' => '编辑分类',
                    'category' => $category,
                    'error' => $e->getError()
                ]);
            }
        }
        return view('edit', [
            'title' => '编辑分类',
            'category' => $category
        ]);
    }

    public function index(UserService $service, CategoryService $categoryService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }

        $userId = $service->userId();
        $categories = $categoryService->getAllByUser($userId);
        return view('', [
            'title' => '分类管理',
            'list' => $categories->all(),
        ]);
    }

    public function delete(UserService $service, CategoryService $categoryService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        try {
            $userId = $service->userId();
            $categoryId = request()->get('id');
            $categoryService->delete($categoryId, $userId);
            return redirect('/user.category/');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}