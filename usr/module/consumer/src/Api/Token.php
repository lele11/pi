<?php
namespace Module\Consumer\Api;

use Pi;
use Pi\Application\AbstractApi;
class Token extends AbstractApi
{
    protected $module = 'consumer';
    /**
    * 获取已保存的token，如果只有refreshed token则使用refresh token 重新获取
    *
    * @param $config = array('client_id' => 'value', 'client_secret' => 'value' , 'server_host' => 'value') 
    *        client_id , client_secret : client module 的身份信息
    *        server_host : Oauth 授权服务器的地址
    * @return array 没有token则为false
    */
    public function getToken($config)
    {
        //首先 查询数据库 是否存在 ，否则开始授权流程，是否过期 ，否则进入刷新流程，是否有refresh ，否则进入授权流程 
        $oauth = Pi::service('api')->consumer(array('server','getServer'),$config());
        $token = $oauth->getTokenFromSess();
        if (!$token) {
            return false;
        } elseif (!isset($token['access_token'])) {
            return $token = $oauth->refreshToken($toke['refresh_token']);
        } else {
            return $token;
        }
    }

    public function setToken()
    {
        
    }
    public function revokeToken()
    {
        $oauth = Pi::service('api')->consumer(array('server','getServer'),$config());
        // $token = $oauth->getToken();
        $oauth->revokeToken();
    }
}