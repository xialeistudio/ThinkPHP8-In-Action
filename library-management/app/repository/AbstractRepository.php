<?php
/**
 * File: AbstractRepository.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\repository;

use app\BaseObject;
use Exception;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;
use think\Paginator;

/**
 * 仓储层
 * Class AbstractRepository
 * @package app\common\repository
 */
abstract class AbstractRepository extends BaseObject
{
    /**
     * 模型类
     * @return string|Model
     */
    abstract protected function modelClass();

    /**
     * 新增数据
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function insert(array $data)
    {
        $className = $this->modelClass();
        $model = new $className();
        $model->data($data);
        if (!$model->save()) {
            throw new Exception('新增失败');
        }
        return $model;
    }

    /**
     * 查找一条数据
     * @param array $conditions
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function findOne(array $conditions)
    {
        $className = $this->modelClass();
        return $className::where($conditions)->find();
    }

    /**
     * 更新数据
     * @param Model $model
     * @param array $data
     * @return mixed
     */
    public function update(Model $model, array $data)
    {
        return $model->save($data);
    }

    /**
     * 删除数据
     * @param array $conditions
     * @return int
     * @throws Exception
     */
    public function delete(array $conditions)
    {
        $className = $this->modelClass();
        $deleteCount = $className::where($conditions)->delete();
        if (!$deleteCount) {
            throw new Exception('删除失败');
        }
        return $deleteCount;
    }

    /**
     * 搜索列表
     * @param int $size
     * @param array $condition
     * @param null $column
     * @param null $keyword
     * @param array $with
     * @param array $orderBy
     * @param array $excludeFields
     * @return Paginator
     * @throws DbException
     */
    public function listBySearch($size = 10, $condition = [], $column = null, $keyword = null, $with = [], $orderBy = [])
    {
        $className = $this->modelClass();
        $query = $className::with($with)->order($orderBy);
        if (!empty($keyword) && !empty($column)) {
            $query->whereLike($column, '%' . $keyword . '%');
        }
        if (!empty($condition)) {
            $query->where($condition);
        }
        return $query->paginate([
            'query' => request()->get(), //url额外参数
            'var_page' => 'page', //分页变量
            'list_rows' => $size, //每页数量
        ]);
    }

    /**
     * 获取所有数据
     * @param array $conditions
     * @return array|Collection|Model[]
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function all(array $conditions = [])
    {
        $className = $this->modelClass();
        $model = new $className();
        if (!empty($conditions)) {
            $model->where($conditions);
        }
        return $model->select();
    }
}