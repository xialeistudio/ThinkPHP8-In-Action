<?php
/**
 * File: Repository.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app\service;

use app\BaseObject;
use Exception;
use PDOStatement;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;
use think\Paginator;

abstract class Repository extends BaseObject
{
    /**
     * 模型类
     * @return string|Model
     */
    abstract protected function modelClass();

    /**
     * 新增数据
     * @param array $data
     * @return mixed|Model
     */
    public function insert(array $data)
    {
        $className = $this->modelClass();
        /** @var Model $model */
        $model = new $className();
        if(!$model->save($data)) {
            throw new Exception('新增失败');
        };
        return $model;
    }

    /**
     * 查找一条数据
     * @param array $conditions
     * @return Model
     * @throws DbException
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
     * @return mixed|Model
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
     * 分页数据
     * @param int $size
     * @param array $conditions
     * @return Paginator
     * @throws DbException
     */
    public function listByPage($size = 10, array $conditions = [])
    {
        $className = $this->modelClass();
        return $className::where($conditions)->paginate([
            'list_rows' => $size,
            'query' => request()->get()
        ]);
    }

    /**
     * 获取所有数据
     * @param array $conditions
     * @return false|PDOStatement|string|Collection
     * @throws DbException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function all(array $conditions = [])
    {
        $className = $this->modelClass();
        $query = $className::query();
        if (!empty($conditions)) {
            $query->where($conditions);
        }
        return $query->select();
    }
}