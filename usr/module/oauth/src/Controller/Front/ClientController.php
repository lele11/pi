<?php
namespace Module\Oauth\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Oauth\Provider\Service as Oauth;
use Module\Oauth\Form\ClientRegisterForm;
use Module\Oauth\Form\ClientRegisterFilter;
use Module\Oauth\Lib\UserHandler as User;

class ClientController extends ActionController
{
    protected $config = array(
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
            )
        );
    public function indexAction()
    {
        // $this->view()->setTemplate('client-index');
    }

    /**
    * register action , should login before register 
    */
    public function registerAction()
    {
        if (!User::isLogin()) {
            $login_page = 'http://pi-oauth.com/system/login/index';
            $this->view()->assign('login',$login_page);
            $this->view()->setTemplate('authorize-redirect');
            return;
        }
        $form = new ClientRegisterForm();
        $form->setAttribute('method','POST');
        $form->setAttribute('action', $this->url('', array('action' => 'register')));
        if ($this->request->ispost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            $form->setInputFilter(new ClientRegisterFilter);
            if(!$form->isValid()) {
                $this->view()->assign('form', $form);
                return;
            }
            $uid = User::getUserid();
            $data = $form->getData();            
            $data = array(
                'client_name' => $data['clientname'],
                'redirect_uri' => urldecode(urldecode($data['redirect_uri'])),
                'uid' => $uid,
                'type' => 'public',
                'client_desc' => $data['clientdesc'],
                );
            Oauth::boot($this->config);
            $result = Oauth::storage('client')->addClient($data);
            $this->redirect()->toUrl('/oauth/client/list');
            return;
        }
        $this->view()->assign('form', $form);
        $this->view()->setTemplate('client-register');        
    }

    /**
    * there is a client id ,show info of this client
    * or show client list with brife info
    */
    public function listAction()
    {
        $id = $this->params('id', '');
        Oauth::boot($this->config);
        if (!$id) {
            $userid = User::getUserid();
            $result = Oauth::storage('client')->getClientByUid($userid);
            $this->view()->assign('client', $result);
            $this->view()->setTemplate('client-list');
        } else {
            $result = Oauth::storage('client')->get($id);
            $this->view()->assign('client', $result);
            $this->view()->setTemplate('client-info');
        }      
    }
    /**
    * delete a client 
    */
    public function deleteAction()
    {
        if ($this->request->ispost()) {
            return false;
        }
        Oauth::boot($this->config);
        $result = Oauth::storage('client')->delete($id);
    }

    /*
    * an ajax action , update client info
    */
    public function updateAction()
    {
        if (!$this->request->ispost()) {
            return false;
        }
        $post = $this->request->getPost();
        Oauth::boot($this->config);
        $result = Oauth::storage('client')->update($post['id'],$post);
        return $result;
    }
}