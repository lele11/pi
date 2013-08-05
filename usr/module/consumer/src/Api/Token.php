<?php
namespace Module\Consumer\Api;

use Pi;
use Pi\Application\AbstractApi;
class Token extends AbstractApi
{
    protected $module = 'consumer';

    /**
    * 从session中取得已经存在的token,判断是否过期
    *
    * @return array 
    *       成功返回array('access_token'=>'value', 'refresh_token'=>'value');
    *       失败返回false
    *       token过期则返回 array('refresh_token'=>'value')
    */
    public function getToken($module, $server)
    {
        // $client = $this->getClient($module, $server);   
        if (isset($_SESSION['token'])) {
            $arr = $_SESSION['token'];
        }
        $flag = 0;
        if (isset($arr['access_token']) && $arr['access_token']) {
            $token = array();
            if (time() < $arr['expired']) {
                $flag = 1;
                $token['access_token'] = $arr['access_token'];
            }            
            if (isset($arr['refresh_token']) && $arr['refresh_token']) {
                $flag = -1;
                $token['refresh_token'] = $arr['refresh_token'];
            } 
        } 
        return 
    }
        //get from database
        //if not exisit return null
        //if expires delete 
        //  if refresh exisit return
        // else return
    }
    /**
    * 获取已保存的token，判断过期，是否刷新如果只有refreshed token则使用refresh token 重新获取
    *
    * @param $config = array('client_id' => 'value', 'client_secret' => 'value' , 'server_host' => 'value') 
    *        client_id , client_secret : client module 的身份信息
    *        server_host : Oauth 授权服务器的地址
    * @return token 存在 ，array 
    *         token过期，存在刷新token 返回
    *         否则， 返回 false
    */
    public function getAccessToken($module, $server, $next , $type = 'code', $data = '')
    {
        //首先 查询数据库 是否存在 ，否则开始授权流程，是否过期 ，否则进入刷新流程，是否有refresh ，否则进入授权流程 
        $client = $this->getClient($module, $server);
        if (!$client) {
            return false;
        }
        $oauth = Pi::service('api')->consumer(array('server','getServer'),$client);        
        if ($type == 'code') {
            $authorizeURl = $oauth->getAuthorizeURL($_SERVER['HTTP_HOST'] . '/consumer/auth/callback' );
            return $authorizeURl;
        } 
        $token = $oauth->getAccessToken($type, $key);

        return $token;
    }
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
        if ($data = $row->toArray()) {
            return array(
                'client_id'     => $data[0]['client_id'],
                'client_secret' => $data[0]['client_secret'],
                'server_host'   => $data[0]['server_host'],
            );
        } else {
            return false;
        }
    }
}