<?php
/**
 * File: Lend.php
 * User: xialeistudio
 * Date: 2024/7/1
 **/

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\BookLendService;
use app\service\BookService;

class Lend extends BaseController
{
    public function index()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $list = BookLendService::Factory()->lendList(10);
        return view('index', [
            'list' => $list->all(),
            'page' => $list->render()
        ]);
    }

    public function add()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $books = BookService::Factory()->list(999, null, \app\model\Book::STATUS_NORMAL);
        $users = \app\service\UserService::Factory()->list(999);

        return view('add', [
            'books' => $books,
            'users' => $users
        ]);
    }

    public function do_add()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }

        $data = \request()->post();
        try {
            $this->validate($data, [
                'book_id' => 'require|integer',
                'user_id' => 'require|integer',
                'lending_date' => 'require|date',
                'should_return_date' => 'require|date',
                'remark' => 'string'
            ]);
            if(strtotime($data['should_return_date']) < strtotime($data['lending_date'])) {
                throw new \Exception('应还日期错误');
            }
            BookLendService::Factory()->lend($data['book_id'], $data['user_id'], $this->adminId(), \request()->ip(), $data);
            return $this->success('借阅成功','/lend');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $bookId = $request->get('book_id');
        $userId = $request->get('user_id');
        try {

            $lend = BookLendService::Factory()->findOne($bookId, $userId);
            $books = BookService::Factory()->list(999, null, null);
            $users = \app\service\UserService::Factory()->list(999);
            return view('update', [
                'lend' => $lend,
                'books' => $books,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function do_update()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $data = \request()->post();
        try {
            $this->validate($data, [
                'book_id' => 'require|integer',
                'user_id' => 'require|integer',
                'lending_date' => 'require|date',
                'should_return_date' => 'require|date',
                'remark' => 'string'
            ]);
            if(strtotime($data['should_return_date']) < strtotime($data['lending_date'])) {
                throw new \Exception('应还日期错误');
            }
            BookLendService::Factory()->update($data['book_id'], $data['user_id'], $this->adminId(), \request()->ip(), $data);
            return $this->success('更新成功','/lend');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function return()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $bookId = \request()->get('book_id');
        $userId = \request()->get('user_id');
        try {
            BookLendService::Factory()->return($bookId, $userId, $this->adminId(), \request()->ip());
            return $this->success('归还成功','/lend');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}