<?php
namespace Module\Consumer\Api;

use Pi;
use Pi\Application\AbstractApi;


/**
* 第三方模块信息的API接口
* 
* 主要功能： 提供某个第三方模块在某个授权服务器上的客户端信息
*  调用方法
*  ~~~
*   Pi::service('api')->consumer(array('client', 'getClient'), $Module_name, $Server_name);
*  ~~~
*
*/

class Client extends AbstractApi
{
    protected $module = 'consumer';

    /**
    * 取得某个客户端在某个授权服务提供方的身份标识
    *
    * @param $name : 客户端的名称
    * @param $server: 授权服务器的名称
    * @return array  ('client_id' => 'value','client_secret' => 'value', 'server_host' => 'value')| false
    */
    public function getClient($name, $server)
    {
        $row = Pi::model('oauth_clientID')->select(array(
            'name'   => $name,
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
}