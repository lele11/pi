<?php
namespace Module\Consumer\Api;

use Pi;
use Pi\Application\AbstractApi;

class Login extends AbstractApi
{
    protected $module = 'consumer';

    /**
    * 生成一段页面代码，点击即可实现Oauth授权登录服务
    *
    * @param $next = "string" 授权登录服务完成后，浏览器的跳转地址 默认为空时 调整到站点主页
    * @param $config = array('client_id' => 'value', 'client_secret' => 'value', 'server_host' => 'value')；
    *   如果config = NULL，则使用模块的配置
    * @return login code
    */
    public function oauthLogin($next = NULL, $config = NULL)
    {
        if (!$config) {
            $config = Pi::service('registry')->config->read('consumer');
        }
        $oauth = Pi::service('api')->consumer(array('server', 'getserver'),$config);
        $nextUrl = $next ? '/next-' . $next : '';
        $url = $oauth->getAuthorizeURL('pi-oauth.com/consumer/auth/callback' . $nextUrl);
        return '<a href="JavaScript:login();">使用OAuth登录</a> 
                <script type="text/javascript">
                function login(){
                    window.open("'.$url.'")
                }
                </script>
        ';
    }

    public function oauthLogout()
    {
        if(isset($_SESSION['token'])) {
            unset($_SESSION['token']);
        }
    }
}