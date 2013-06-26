<?php
namespace Module\Oauth\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Oauth\Provider\Service as Oauth;

class TokenController extends ActionController
{
    public function indexAction()
    {

    }

    public function revokeAction()
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
                    'token_type'    => array(
                        'bearer'    => array(),
                        'mac'       => array(),
                    ),
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
            )
        );
        $params = array(
            'refreshToken'  => $this->params('refresh_token',''),
            'grant_type'    => $this->params('grant_type',''),
        );
        Oauth::boot($config);
        $resource = Oauth::server('resource');
        $request = Oauth::request();
        $request->setParameters($params);
        $resource->process($request);
        return ;
    }

    public function validAction()
    {

    }
}