<?php
namespace Module\Oauth\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Oauth\Provider\Service as Oauth;
use Module\Oauth\Lib\UserHandler as User;

class GrantController extends ActionController
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
        'client' => array(
            'model_set'             => array(
                'name'      => 'database',
                'config'    => array(
                    'table_prefix'  => 'oauth',
            ),
        ),      
    ),
        ));

        Oauth::boot($config);
        $grant = Oauth::server('grant');
        $request = Oauth::request();
        $request->setParameters($this->getParams());
        $grant->process($request);
        $result = $grant->getResult();
        $result->send();
        $this->view()->setTemplate(false);
    }

    protected function getParams()
    {
        return array(
            'code'          => $this->params('code',''),
            'client_id'     => $this->params('client_id',''),
            'client_secret' => $this->params('client_secret',''),
            'redirect_uri'  => $this->params('redirect_uri',''),
            'grant_type'    => $this->params('grant_type',''),
            'scope'         => $this->params('scope',''),
        );
        // $code = $this->params('code','');
        // $client_id = $this->params('client_id','');
        // $client_secret = $this->params('client_secret','');
        // $redirect_uri = $this->params('redirect_uri','');
        // $grant_type = $this->params('grant_type','');

    }
}