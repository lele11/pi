<?php

namespace Module\Consumer\Api;

use Pi;
use Pi\Application\AbstractApi;
 
class Server extends AbstractApi
{
    
    public $client_id;
  
    public $client_secret;
 
    public $access_token;
  
    public $refresh_token;

    public $host ;

    public $timeout = 30;
 
    public $connecttimeout = 30;
 
    public $ssl_verifypeer = FALSE;

    public $format = 'json';
 
    public $decode_json = TRUE;
   
    public $useragent = 'OAuth consumer';

    public $debug = FALSE; 

    protected $module = 'consumer';
   
    function accessTokenURL()  { return $this->host . '/oauth/grant/index'; }
  
    function authorizeURL()    { return $this->host . '/oauth/authorize/index'; }
 
    /**
     * construct OAuth object
     */
    function getServer($config)
    {
        $this->__construct($config);
        return $this;
    }
    function __construct($config) 
    {
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
        $this->host = $config['server_host'];
    }
 
    /**
     * authorize接口
     *
     * @param string $url 授权后的回调地址,站外应用需与回调地址一致,站内应用需要填写canvas page的地址
     * @param string $response_type 支持的值包括 code 和token 默认值为code
     * @param string $state 用于保持请求和回调的状态。在回调时,会在Query Parameter中回传该参数
     *
     * @return array 
     */
    function getAuthorizeURL( $url, $response_type = 'code' ) 
    {
        $params = array();
        $params['client_id'] = $this->client_id;
        $params['redirect_uri'] = $url;
        $params['response_type'] = $response_type;
        $params['state'] = $this->setState();
        $params['scope'] = 'base';
        return $this->authorizeURL() . "?" . http_build_query($params);
    }
 
    /**
     * 获取access_token
     *
     * @param string $type 请求的类型,可以为:code, password, token
     * @param array $keys 其他参数：
     *   - 当$type为code时： array('code'=>..., 'redirect_uri'=>...)
     *   - 当$type为password时： array('username'=>..., 'password'=>...)
     *   - 当$type为token时： array('refresh_token'=>...)
     * @return array 
     */
    function getAccessToken( $type = 'code', $keys ) 
    {
        $params = array();
        $params['client_id'] = $this->client_id;
        $params['client_secret'] = $this->client_secret;
        if ( $type === 'token' ) {
            $params['grant_type'] = 'refresh_token';
            $params['refresh_token'] = $keys['refresh_token'];
        } elseif ( $type === 'code' ) {
            $params['grant_type'] = 'authorization_code';
            $params['code'] = $keys['code'];
            $params['redirect_uri'] = $keys['redirect_uri'];
        } elseif ( $type === 'password' ) {
            $params['grant_type'] = 'password';
            $params['username'] = $keys['username'];
            $params['password'] = $keys['password'];
        } else {
            $this->error("wrong auth type");
        }
 
        $response = $this->oAuthRequest($this->accessTokenURL(), 'POST', $params);
        $token = json_decode($response, true);
        if ( is_array($token) && !isset($token['error']) ) {
            $this->setToken($token);
        } 
        return $token;
    }
 
    /**
    * 当token过期后，使用refresh token 重新获取access_token
    *
    * @return array
    */
    function refreshToken()
    {
        $token = $this->getTokenFromSess();
        $response = $this->oAuthRequest($this->refreshTokenURL(), 'GET', $params);
        $token = json_decode($response, true);
        if ( is_array($token) && !isset($token['error']) ) {
            $this->setToken($token);
        }        
        return $token;
    }

    /**
    * 保持token到 session中
    * 
    */
    function setToken($token)
    {
        if ($_SESSION) {
            session_start();
        }
        if (!$token) {
            return false;
        }        
        $token['expired'] = time() + $token['expire_in'];
        unset($token['expire_in']);
        $_SESSION['token'] = $token;
    }

    /**
    * 从session中取得已经存在的token,判断是否过期
    *
    * @return array 
    *       成功返回array('access_token'=>'value', 'refresh_token'=>'value');
    *       失败返回false
    *       token过期则返回 array('refresh_token'=>'value')
    */
    function getTokenFromSess()
    {
        if (isset($_SESSION['token'])) {
            $arr = $_SESSION['token'];
        }
        if (isset($arr['access_token']) && $arr['access_token']) {
            $token = array();
            if (time() < $arr['expired']) {
                $token['access_token'] = $arr['access_token'];
            }            
            if (isset($arr['refresh_token']) && $arr['refresh_token']) {
                $token['refresh_token'] = $arr['refresh_token'];
            } 
            return $token;
        } else {
            return false;
        }
    }
    /**
     * implicit 授权时，从cookie中获取token
     *
     * @return array 成功返回array('access_token'=>'value', 'refresh_token'=>'value'); 失败返回false
     */
    function getTokenFromJS() 
    {
        $key = "oauth_" . $this->client_id;
        if ( isset($_COOKIE[$key]) && $cookie = $_COOKIE[$key] ) {
            parse_str($cookie, $token);
            if ( isset($token['access_token']) && isset($token['refresh_token']) ) {
                $this->access_token = $token['access_token'];
                $this->refresh_token = $token['refresh_token'];
                return $token;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
 
    /**
     * Format and sign an OAuth request
     *
     * @return string 
     * @ignore
     */
    function oAuthRequest($url, $method, $parameters) 
    { 
        if (strrpos($url, 'http://') !== 0 && strrpos($url, 'https://') !== 0) {
            $url = "{$this->host}{$url}.{$this->format}";
        }
 
        switch ($method) {
            case 'GET':
                $url = $url . '?' . http_build_query($parameters);
                return $this->http($url, 'GET');
            default:
                $headers = array();
                if ( is_array($parameters) ) {
                    $body = http_build_query($parameters);
                }
                $headers[] = "X-Requested-With:XMLHttpRequest";
                $headers[] = "Accept: application/json";
                $headers[] = "Content-Type: application/x-www-form-urlencoded";
                return $this->http($url, $method, $body, $headers);
        }
    }
 
    /**
     * Make an HTTP request
     *
     * @return string API results
     * @ignore
     */
    function http($url, $method, $postfields = NULL, $headers = array()) 
    {
        $ci = curl_init();        
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_ENCODING, "");
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ci, CURLOPT_HEADER, FALSE);
 
        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, TRUE);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
            case 'DELETE':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($postfields)) {
                    $url = "{$url}?{$postfields}";
                }
        }
        curl_setopt($ci, CURLOPT_URL, $url );
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );
 
        $response = curl_exec($ci);
 
        if ($this->debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
 
            echo "=====headers======\r\n";
            print_r($headers);
 
            echo '=====request info====='."\r\n";
            print_r( curl_getinfo($ci) );
 
            echo '=====response====='."\r\n";
            print_r( $response );
        }
        curl_close ($ci);
        return $response;
    }

    function setState()
    {
        $state = base64_encode(rand()."df");
        if (isset($_SESSION['state'])) {
            unset($_SESSION['state']);
        }
        $_SESSION['state'] = $state;
        return $state;
    }
    function error( $error)
    {
        echo $error;
    }
}