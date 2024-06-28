<?php
/**
 * File: Post.php
 * User: xialeistudio
 * Date: 2024/6/28
 **/

namespace app\controller\user;

use app\BaseController;
use app\model\Category;
use app\service\CategoryService;
use app\service\PostService;
use app\service\UserService;
use think\exception\ValidateException;

class
Post extends BaseController
{
    public function publish(UserService $service, PostService $postService, CategoryService $categoryService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        $userId = $service->userId();
        if (request()->isPost()) {
            try {
                $data = request()->post();
                $this->validate($data, [
                    'title|标题' => 'require|max:100',
                    'content|内容' => 'require',
                    'status|状态' => 'require|in:1,2,3',
                    'top|置顶' => 'in:0,1',
                    'sort|排序' => 'require|integer',
                    'category_id|分类' => 'require|integer'
                ]);
                $postService->publish($userId, $data);
                return redirect('/user');
            } catch (ValidateException $e) {
                return view('publish', [
                    'title' => '发表文章',
                    'error' => $e->getError()
                ]);
            }
        }
        $categories = $categoryService->getAllByUser($userId, Category::STATUS_VISIBLE);
        return view('publish', [
            'title' => '发表文章',
            'categories' => $categories->all()
        ]);
    }

    public function edit(UserService $service, PostService $postService, CategoryService $categoryService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        $id = request()->get('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        $userId = $service->userId();
        $post = $postService->show($id, $userId);
        $categories = $categoryService->getAllByUser($userId, Category::STATUS_VISIBLE);
        if (request()->isPost()) {
            try {
                $data = request()->post();
                $this->validate($data, [
                    'title|标题' => 'require|max:100',
                    'content|内容' => 'require',
                    'status|状态' => 'require|in:1,2,3',
                    'top|置顶' => 'in:0,1',
                    'sort|排序' => 'require|integer',
                    'category_id|分类' => 'require|integer'
                ]);
                $postService->update($id, $userId, $data);
                return redirect('/user');
            } catch (ValidateException $e) {
                return view('edit', [
                    'title' => '编辑文章',
                    'post' => $post,
                    'error' => $e->getError(),
                    'categories' => $categories->all()
                ]);
            }
        }
        return view('edit', [
            'title' => '编辑文章',
            'post' => $post,
            'categories' => $categories->all()
        ]);
    }

    public function delete(UserService $service, PostService $postService)
    {
        if ($service->isGuest()) {
            return $service->loginRequired();
        }
        try {
            $userId = $service->userId();
            $postId = request()->get('id');
            $postService->delete($postId, $userId);
            return redirect('/user');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}