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
    * @return array 没有token则为false
    */
    public function getToken()
    {
        //首先 查询数据库 是否存在 ，否则开始授权流程，是否过期 ，否则进入刷新流程，是否有refresh ，否则进入授权流程 
        $oauth = Pi::service('api')->consumer(array('test','gettest'),$this->config());
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
        //授权流程完成后 将token 保存到数据库中
    }
    public function revokeToken()
    {
        
    }
}