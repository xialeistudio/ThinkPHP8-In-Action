<?php
/**
 * File: Index.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\controller;

use app\BaseController;
use app\Request;
use app\service\AdminService;
use app\service\BookService;
use think\facade\View;

class Index extends BaseController
{
    public function index(Request $request)
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $status = $request->get('status');
        if ($status === '') {
            $status = null;
        }
        $list = BookService::Factory()->list(10, $request->get('keyword'), $status);

        return view('index', [
            'list' => $list->all(),
            'page' => $list->render(),
            'status' => $status
        ]);
    }

    public function changepwd()
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        return view('changepwd');
    }

    public function do_changepwd(Request $request)
    {
        if ($this->isGuest()) {
            return $this->loginRequired();
        }
        $errmsg = $this->validate($request->post(), [
            'old_password|当前密码' => 'require',
            'new_password|新密码' => 'require',
            'new_password_confirm|确认密码' => 'require|confirm:new_password'
        ]);
        if ($errmsg !== true) {
            return $this->error($errmsg);
        }
        AdminService::Factory()->changePwd($this->adminId(), $request->post('old_password'), $request->post('new_password'));
        return $this->success('操作成功', 'index');
    }
}