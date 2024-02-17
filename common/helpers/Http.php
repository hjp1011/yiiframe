<?php

namespace common\helpers;

use Yii;
use yii\web\NotFoundHttpException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

/**
 * Http请求服务
 */
class Http
{
    /**
     * 获取远程服务器
     * @return  string
     */
    protected static function getServerUrl()
    {
        return \yiiframe\plugs\services\UpdateService::$host;
    }
    /**
     * 获取请求对象
     * @return Client
     */
    public static function getClient()
    {
        $options = [
            'base_uri'        => self::getServerUrl(),
            'timeout'         => 30,
            'connect_timeout' => 30,
            'verify'          => false,
            'http_errors'     => false,
            'headers'         => [
                'X-REQUESTED-WITH' => 'XMLHttpRequest',
                // 'Referer'          => true,
                'User-Agent'       => 'FastAddon',
            ]
        ];
        static $client;
        if (empty($client)) {
            $client = new Client($options);
        }
        return $client;
    }
    /**
     * 发送请求
     * @return array
     * @throws Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendRequest($url, $params = [], $method = 'POST')
    {
        $json = [];
        try {
            $client = self::getClient();
            $options = strtoupper($method) == 'POST' ? ['form_params' => $params] : ['query' => $params];
            $response = $client->request($method, $url, $options);
            $body = $response->getBody();
            $content = $body->getContents();
            $json = (array)json_decode($content, true);
        } catch (TransferException $e) {
            throw new NotFoundHttpException('Network error');
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Unknown data format');
        }
        return $json;
    }

   
}
