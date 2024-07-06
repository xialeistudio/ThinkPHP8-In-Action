<?php
/**
 * File: Order.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\controller\admin;

use app\BaseController;
use app\Request;
use app\service\admin\OrderService;
use Exception;

class Order extends BaseController
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function index(Request $request)
    {
        if($this->isAdminGuest()) {
            return $this->adminLoginRequired();
        }
        try {
            $status = $request->get('status');
            $status = $status === '' ? null : $status;
            $size = $request->get('size', 10);
            $list = OrderService::Factory()->list($status, $size);
            return view('index', [
                'list' => $list
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}