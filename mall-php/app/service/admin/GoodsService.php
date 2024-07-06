<?php
/**
 * File: GoodsService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service\admin;

use app\model\Goods;
use app\service\Service;
use Exception;
use think\db\exception\DbException;
use think\Paginator;

class GoodsService extends Service
{
    /**
     * 发布商品
     * @param array $data
     * @return Goods
     * @throws Exception
     */
    public function publish(array $data)
    {
        $model = new Goods();
        $model->data($data);
        if (!$model->save()) {
            throw new Exception('添加商品失败', 500);
        }
        return $model;
    }

    /**
     * 删除
     * @param array $data
     * @return Goods|null
     * @throws Exception
     * @throws DbException
     */
    public function update(array $data)
    {
        $goods = Goods::find($data['id']);
        if (empty($goods)) {
            throw new Exception('商品不存在', 404);
        }
        $goods->data($data);
        if (!$goods->save()) {
            throw new Exception('编辑失败');
        }
        return $goods;
    }

    /**
     * 商品列表
     * @param int $size
     * @param string|null $keyword
     * @return Paginator
     * @throws DbException
     */
    public function list($size = 10, $keyword = null)
    {
        $model = Goods::query();
        if (!empty($keyword)) {
            $model->whereLike('title', $keyword);
        }
        $model->withoutField(['content']);
        $model->order(['id' => 'desc']);
        return $model->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 删除
     * @param int $id
     * @throws DbException
     * @throws Exception
     */
    public function delete($id)
    {
        $model = Goods::find($id);
        if (empty($model)) {
            throw new Exception('商品不存在', 404);
        }
        if (!$model->delete()) {
            throw new Exception('删除失败');
        }
    }

    /**
     * @param int $id
     * @return Goods|null
     * @throws DbException
     * @throws Exception
     */
    public function show($id)
    {
        $goods = Goods::find($id);
        if (empty($goods)) {
            throw new Exception('商品不存在');
        }
        return $goods;
    }
}