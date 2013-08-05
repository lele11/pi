<?php
namespace Module\Consumer\Api;

use Pi;
use Pi\Application\AbstractApi;


/**
* 第三方模块信息的API接口
* 
*  主要方法：
*   - getClient：获取应用模块在consumer模块中保存的数据
*   - getService：通过不同的授权方式获取token，支持code，userPw，clientCredentials，refreshToken
*  调用方法
*  ~~~
*  $client = Pi::service('api')->consumer(array('oAuth', 'getClient'), $module, $server);
*
*  $token = Pi::service('api')->consumer(array('oAuth', 'getService'), $client, $type, $data);
* 
*  ~~~
*
*/

class OAuth extends AbstractApi
{
    protected $module = 'consumer';

    /**
    * 取得某个客户端在某个授权服务提供方的身份标识
    *
    * @param $name : 客户端的名称
    * @param $server: 授权服务器的名称
    * @return array  ('client_id' => 'value','client_secret' => 'value', 'server_host' => 'value')| false
    */
    public function getClient($module, $server = '')
    {
        // if (!$server) {
        //     $config = Pi::service('registry')->config->read('consumer');
        //     $server = $config['server'];
        // }
        $row = Pi::model('oauth_client', 'consumer')->select(array(
            'module'   => $module,
            'server' => $server,
        ));
        if ($row) {
            $data = $row->toArray();
        } else {
            return false;
        }
        return array(
            'client_id'     => $data[0]['client_id'],
            'client_secret' => $data[0]['client_secret'],
            'server_host'   => $data[0]['server_host'],
        );
    }
    /**
    * 应用模块使用OAuth服务的接口,这个接口不支持隐式授权模式
    *
    * @param $client 应用模块的身份信息 array('client_id' => 'value','client_secret' =>'value','server_host'=>'value')
    * @param $type 使用的授权类型 code refresh upw cleintcredetials
    * @return $token
    */
    public function getService($client, $type, $next ,$data = '')
    {
        $oauth = Pi::service('api')->consumer(array('server','getServer'), $client);

        if ($type == 'code') {
            $authorizeURl = $oauth->getAuthorizeURL($_SERVER['HTTP_HOST'] . '/consumer/auth/callback' . $next);
            return $authorizeURl;
        } else {
            $token = $oauth->getAccessToken($type, $key);
        }
        return $token;
    }
}