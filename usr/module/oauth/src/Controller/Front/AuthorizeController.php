<?php
namespace Module\Oauth\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Oauth\Provider\Service as Oauth;
use Module\Oauth\Lib\UserHandler as User;

class AuthorizeController extends ActionController
{
    public function indexAction()
    {
        $config = array(
            'server'    => array(
                'authorization' => array(
                    'response_types'    => array(
                        'code', 'token',
                    ),
                ),
                'grant'     => array(
                    'grant_types'   => array(
                        'authorization_code'    => 'AuthorizationCode',
                        'password'              => 'Password',
                        'client_credentials'    => 'ClientCredentials',
                        'refresh_token'         => 'RefreshToken',
                        'urn:ietf:params:oauth:grant-type:jwt-bearer'
                                                => 'JwtBearer',
                        ),
                    ),
                'resource'  => array(
                    'token_type'    => 'bearer',
                    'www_realm'     => 'service',
                ),
            ),
            'storage'   => array(
                'model_set'             => array(
                        'name'      => 'database',
                        'config'    => array(
                            'table_prefix'  => 'oauth',
                        ),
                'client'                => array(
                    
                    ),
                ),
                'authorization_code'    => array(
                    'expires_in'    => 30,
                    'length'        => 40,
                ),
                'access_token'  => array(
                    'token_type'    => 'bearer',
                    'expires_in'    => 3600,
                    'length'        => 40,
                ),
                'refresh_token' => array(
                    'expires_in'    => 1209600,
                    'length'        => 40,
                ),
            ),
             'response_type' => array(
                'code' => array(
                    'length' => 40,
                    'expires_in' => 40,
                ),
                'token' => array(),

            ),
        );
        /**
        * if user is not logged,redirect to login page ,which is defined by resource owner
        * the login form  may provided by user module 
        * 添加强制登录选项，使用login参数，跳转到登录页面，需要去除，默认跳转不能实现，构造链接需要解决URL编码问题
        * 解决编码问题，页面跳转可使用js和程序两种方式，
        */

        $login_status = $this->params('login',0);
        if (!is_numeric($login_status)) {
            return;
        }

        if (!$login_status) {
            $login_status = !$this->isLogin();
        } else {
            // User::logout();
        }

        if ($login_status) {
            // $this->loginPage();
            $login_page = 'http://pi-oauth.com/system/login/index';
            $this->view()->assign('login',$login_page);
            $this->view()->setTemplate('authorize-redirect');
            return;
        }

        $resource_owner = User::getUserid();

        Oauth::boot($config);
        $authorize = Oauth::server('authorization');
        $request = Oauth::request();
        $params = $this->getParams();
        $params['resource_owner'] = $resource_owner;
        $request->setParameters($params); 

        if ($authorize->process($request) && !$this->request->ispost()) {
            $this->view()->assign('backuri',$request->getServer('HTTP_REFERER'));       
            $this->view()->setTemplate('authorize-auth');
            return;            
        }
        $result = $authorize->getResult();           
        $this->view()->setTemplate('df');
        $result->send();
        return;        
    }

    /**
    * redirect to login page ,the address of log page is provided by resource owner 
    * 原计划使用函数进行跳转，由于URL转码问题，使用JavaScript进行
    */
    protected function loginPage()
    {
        $loacation = Pi::url('') . $this->request->getServer('REDIRECT_URL');        
        $resource_login = 'http://pi-oauth.com/system/login/index/';
        $this->redirect()->toUrl($resource_login);
    }

    /**
    * check if user logged
    * @return bool
    */
    protected function isLogin()
    {
        return User::isLogin();
    }
    /**
    * get paramesters of request  
    *
    * @return array
    */
    protected function getParams() 
    {
        $clientid = $this->params('client_id');
        $response_type = $this->params('response_type');
        $redirect_uri = $this->params('redirect_uri');
        $state = $this->params('state');
        $scope = $this->params('scope');
        return array(
            'client_id'     => $clientid, 
            'response_type' => $response_type,
            'redirect_uri'  => $redirect_uri,
            'state'         => $state,
            'scope'         => $scope,
        );
    }

    /**
    * check if user has been authorized the client
    * @return bool 
    */
    public function isAuthorize()
    {

    }
}