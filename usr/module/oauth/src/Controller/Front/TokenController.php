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


    /**
    * get new access token by refersh token
    * params :  grant_type  must "refersh_token',
    *           refersh_token 
    *           client_id :optional /may use other authorization method to auth client
    * @return json  like access_token
    */
    public function refershAction()
    {
        $config = $this->config();
        $params = array(
            'refresh_token'  => $this->params('refresh_token',''),
            'grant_type'    => $this->params('grant_type',''),
            'client_id'     => $this->params('client_id',''),
        );
        Oauth::boot($config);
        $grant = Oauth::server('grant');
        $request = Oauth::request();
        $request->setParameters($params);
        $grant->process($request);
        $result = $grant->getResult();
        $result->addContent();
        // $this->view()->setTemplate(false);
        return $result;
        // $this->response->setStatusCode($result->getStatusCode());
        // $this->response->setHeaders($result->getHeaders());
        // $this->response->setContent($result->setContent()->getContent());
        // return $this->response;
    }


    public function config()
    {
        return $config = array(
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
    }
}