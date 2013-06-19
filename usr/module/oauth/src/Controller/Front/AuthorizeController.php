<?php
namespace Module\Oauth\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Oauth\Provider\Service as Oauth;
use Module\Systme\Form\LoginForm;
// use Module\Oauth\Form\AuthorizationForm;

class AuthorizeController extends ActionController
{
    public function indexAction()
    {
        //get config 
        //new a service
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
        Oauth::boot($config);
        $authorize =  Oauth::server('authorization');
        $request = Oauth::request();
        /** set requeste parameters 
        */
        $request->setParameters($this->getParams());
        $authorize->process($request);
        $result = $authorize->getResult();
        $result->send();
        exit();
    }

    public function authorizeAction()
    {
        $server = new Oauth();
        $server->boot($config);
        $server_config = $server->config('server','grant');
    }

    public function loginAction()
    {
        $form = $this->authorizeLoginForm();
        $this->view()->assign('form',$form);
        $this->view()->setTemplate('authorize-auth');
    }

    protected function authorizeLoginForm()
    {
        $form = new LoginForm('login');
        $form->setAttribute('action', $this->url('', array('action' => 'login')));

        return $form;
    }
    protected function isLogin()
    {

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
            'scope'         => $scope
        );
    }
    protected function config()
    {
             $config = array(
    'server'    => array(
        'authorization' => array(
            'response_types'    => array(
                'code', 'token',
            ),
        ),
        'grant' => array(
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
);
    }
}