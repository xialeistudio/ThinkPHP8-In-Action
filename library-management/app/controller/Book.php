<?php
/**
 * File: Book.php
 * User: xialeistudio
 * Date: 2024/7/1
 **/

namespace app\controller;

use app\BaseController;
use app\service\BookService;

class Book extends BaseController
{
    public function add()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        return view('add');
    }

    public function do_add()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $data = request()->post();
        try {
            $this->validate($data, [
                'isbn|ISBN' => 'require|integer',
                'title|书名' => 'require|max:100',
                'author|作者' => 'require|max:40',
                'publisher|出版社' => 'require|max:40',
                'price|价格' => 'require|float',
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        BookService::Factory()->add($data, $this->adminId(), request()->ip());
        return $this->success('添加成功', '/');
    }

    public function edit()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $bookId = request()->get('id');
        try {
            $book = BookService::Factory()->findOne($bookId);
            return view('edit', [
                'book' => $book
            ]);
        } catch (\Exception $e) {
            return $this->error('书籍不存在');
        }
    }

    public function do_edit()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $bookId = request()->get('id');
        try {
            BookService::Factory()->findOne($bookId);
        } catch (\Exception $e) {
            return $this->error('书籍不存在');
        }
        $data = request()->post();
        try {
            $this->validate($data, [
                'isbn|ISBN' => 'require|integer',
                'title|书名' => 'require|max:100',
                'author|作者' => 'require|max:40',
                'publisher|出版社' => 'require|max:40',
                'price|价格' => 'require|float',
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        BookService::Factory()->update($bookId, $data, $this->adminId(), request()->ip());
        return $this->success('编辑成功', '/');
    }

    public function logs()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $bookId = request()->get('id');
        $logs = BookService::Factory()->getBookLogs($bookId);
        return view('logs', [
            'list' => $logs->all(),
            'page' => $logs->render()
        ]);
    }
}