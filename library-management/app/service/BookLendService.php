<?php
/**
 * File: BookLendService.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\service;

use app\BaseObject;
use app\helper\ArrayHelper;
use app\model\AdminLog;
use app\model\Book;
use app\model\BookLending;
use app\model\BookLog;
use app\repository\Repository;
use Exception;
use think\db\Query;
use think\facade\Db;
use think\Paginator;

/**
 * 借书业务
 */
class BookLendService extends BaseObject
{
    /**
     * 借出
     * @param $bookId
     * @param $userId
     * @param $adminId
     * @param $ip
     * @param array $data
     * @return mixed
     */
    public function lend($bookId, $userId, $adminId, $ip, array $data)
    {
        $data = ArrayHelper::filter($data, ['lending_date', 'should_return_date', 'remark']);
        return Db::transaction(function () use ($bookId, $userId, $adminId, $ip, $data) {
            $book = BookService::Factory()->findOne($bookId);
            if ($book->status != Book::STATUS_NORMAL) {
                throw new Exception('该书籍已借出');
            }
            if (strtotime($data['should_return_date']) < strtotime($data['lending_date'])) {
                throw new Exception('应还日期错误');
            }
            Repository::ModelFactory(Book::class)->update($book, ['status' => Book::STATUS_LEND]);
            // 借出记录
            Repository::ModelFactory(BookLending::class)->insert([
                'book_id' => $bookId,
                'user_id' => $userId,
                'lending_date' => $data['lending_date'],
                'should_return_date' => $data['should_return_date'],
                'return_at' => 0,
                'remark' => $data['remark']
            ]);
            // 日志
            AdminService::Factory()->log($adminId, AdminLog::ACTION_LEND_BOOK, '书籍借出', ['book_id' => $bookId, 'user_id' => $userId], $ip);
            BookService::Factory()->log($bookId, BookLog::ACTION_LEND, '借出', ['admin_id' => $adminId], $ip);
            return $book;
        });
    }

    /**
     * 借出列表
     * @param int $size
     * @param null $keyword
     * @return Paginator
     */
    public function lendList($size = 10, $keyword = null)
    {
        return Repository::ModelFactory(BookLending::class)
            ->listBySearch($size, [], null, null, [
                'book' => function (Query $query) use ($keyword) {
                    if (!empty($keyword)) {
                        $query->whereLike(['isbn','title','author','publisher'], $keyword, 'OR');
                    }
                },
                'user' => function (Query $query) use ($keyword) {
                    if (!empty($keyword)) {
                        $query->whereLike(['realname','phone'], $keyword, 'OR');
                    }
                }
            ], ['created_at' => 'desc']);
    }

    /**
     * 编辑借出记录
     * @param int $bookId
     * @param int $userId
     * @param array $data
     * @param $adminId
     * @param $ip
     * @return mixed
     */
    public function update($bookId, $userId, array $data, $adminId, $ip)
    {
        $data = ArrayHelper::filter($data, ['remark']);
        return Db::transaction(function () use ($bookId, $userId, $data, $adminId, $ip) {
            $lend = Repository::ModelFactory(BookLending::class)->findOne(['book_id' => $bookId, 'user_id' => $userId]);
            if (empty($lend)) {
                throw new Exception('借出记录不存在');
            }
            Repository::ModelFactory(BookLending::class)->update($lend, $data);
            // 日志
            AdminService::Factory()->log($adminId, AdminLog::ACTION_UPDATE_BOOK_LEND, '修改借出记录', ['book_id' => $bookId], $ip);

            return $lend;
        });
    }

    /**
     * 归还书籍
     * @param $bookId
     * @param $userId
     * @param $adminId
     * @param $ip
     * @return mixed
     */
    public function return($bookId, $userId, $adminId, $ip)
    {
        return Db::transaction(function () use ($bookId, $userId, $adminId, $ip) {
            /** @var BookLending $lend */
            $lend = Repository::ModelFactory(BookLending::class)->findOne(['book_id' => $bookId, 'user_id' => $userId]);
            if (empty($lend)) {
                throw new Exception('借出记录不存在');
            }
            if ($lend->return_at) {
                throw new Exception('该出借已归还');
            }
            Repository::ModelFactory(BookLending::class)->update($lend, ['return_at' => time()]);
            $book = BookService::Factory()->findOne($bookId);
            Repository::ModelFactory(Book::class)->update($book, ['status' => Book::STATUS_NORMAL]);
            // 日志
            AdminService::Factory()->log($adminId, AdminLog::ACTION_RETURN_BOOK, '归还书籍', ['book_id' => $bookId, 'user_id' => $userId], $ip);
            BookService::Factory()->log($bookId, BookLog::ACTION_RETURN, '归还书籍', ['admin_id' => $adminId, 'user_id' => $userId], $ip);
            return $lend;
        });
    }

    /**
     * 查找
     * @param int $bookId
     * @param int $userId
     * @return mixed
     * @throws Exception
     */
    public function findOne($bookId, $userId)
    {
        $data = Repository::ModelFactory(BookLending::class)->findOne(['book_id' => $bookId, 'user_id' => $userId]);
        if (empty($data)) {
            throw new Exception('借书记录不存在');
        }
        return $data;
    }
}