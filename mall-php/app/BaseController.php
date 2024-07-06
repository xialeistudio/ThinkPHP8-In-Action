<?php
declare (strict_types=1);

namespace app;

use Firebase\JWT\JWT;
use think\App;
use think\Exception;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
    }

    /**
     * 验证数据
     * @access protected
     * @param array $data 数据
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @param bool $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, string|array $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    protected function userId()
    {
        $authorization = $this->request->header('Authorization');
        if (empty($authorization)) {
            throw new Exception('未登录', 401);
        }
        $payload = JWT::decode($authorization, config('app.jwt_key'));
        if ($payload->expired_at < time()) {
            throw new Exception('未登录', 401);
        }

        return $payload->user_id;
    }

    public function success($msg, $callback = null)
    {
        return view('/success', ['msg' => $msg, 'callback' => $callback]);
    }

    public function error($msg)
    {
        return view('/error', ['msg' => $msg]);
    }

    protected function adminLoginRequired()
    {
        return redirect('/admin.auth/login');
    }

    protected function isAdminGuest()
    {
        return !session('admin');
    }
}
