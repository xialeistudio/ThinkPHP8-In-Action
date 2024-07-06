<?php
/**
 * File: Goods.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller\admin;

use app\BaseController;
use app\Request;
use app\service\admin\AdminService;
use app\service\admin\GoodsService;
use Exception;

class Goods extends BaseController
{
    /**
     * 商品列表
     * @param Request $request
     * @return mixed|void
     */
    public function index(Request $request)
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        try {
            $list = GoodsService::Factory()->list($request->get('size', 10), $request->get('keyword'));
            return view('index', ['list' => $list]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function publish()
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        return view('publish');
    }

    /**
     * 发布商品
     * @param Request $request
     */
    public function do_publish(Request $request)
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        try {
            $data = $request->post();
            $thumb = $request->file('thumb');
            if (!empty($thumb)) {
                $data['thumb'] = AdminService::Factory()->upload($thumb);
            }
            $this->validate($data, [
                'title|名称' => 'require|max:40',
                'thumb|缩略图' => 'require',
                'description|简介' => 'max:100',
                'price|价格' => 'require|>=:0',
                'stock|库存' => 'require|>=:0',
                'status|状态' => 'require|>=:0',
                'content|详情内容' => 'require'
            ]);
            GoodsService::Factory()->publish($data);
            return $this->success('发布成功', url('/admin.goods/index'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        try {
            $goods = GoodsService::Factory()->show($request->get('id'));
            return view('update', ['goods' => $goods]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 编辑商品
     * @param Request $request
     */
    public function do_update(Request $request)
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        try {
            $data = $request->post();
            $thumb = $request->file('thumb');
            if (!empty($thumb)) {
                $data['thumb'] = AdminService::Factory()->upload($thumb);
            }
            $this->validate($data, [
                'id|商品ID' => 'require',
                'thumb|缩略图' => 'require',
                'title|名称' => 'require|max:40',
                'description|简介' => 'max:100',
                'price|价格' => 'require|>=:0',
                'stock|库存' => 'require|>=:0',
                'status|状态' => 'require|>=:0',
            ]);
            GoodsService::Factory()->update($data);
            return $this->success('编辑成功', url('/admin.goods/index'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除商品
     * @param Request $request
     */
    public function do_delete(Request $request)
    {
        if ($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        try {
            $this->validate($request->get(), [
                'id|商品ID' => 'require'
            ]);
            GoodsService::Factory()->delete($request->param('id'));
            return $this->success('删除成功', url('/admin.goods/index'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}