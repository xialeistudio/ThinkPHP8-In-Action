<?php
/**
 * File: WechatService.php
 * User: xialeistudio
 * Date: 2024/7/6
 **/

namespace app\service;

use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class WechatService extends Service
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.weixin.qq.com'
        ]);
    }

    /**
     * 处理微信响应
     * @param ResponseInterface $response
     * @return mixed
     * @throws Exception
     */
    protected function handleResponse(ResponseInterface $response)
    {
        $data = json_decode($response->getBody()->getContents(), true);
        if (!empty($data['errcode'])) {
            throw new Exception($data['errmsg'], $data['errcode']);
        }
        return $data;
    }

    /**
     * 获取会话
     * @param string $code
     * @return mixed
     * @throws Exception
     */
    public function getSession($code)
    {
        $response = $this->client->get('/sns/jscode2session', [
            'query' => [
                'appid' => config('app.params.applet.appid'),
                'secret' => config('app.params.applet.secret'),
                'js_code' => $code,
                'grant_type' => 'authorization_code'
            ]
        ]);
        $data = $this->handleResponse($response);
        return $data;
    }
}