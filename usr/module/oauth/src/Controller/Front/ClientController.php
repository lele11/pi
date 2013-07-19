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
    public function registerAction()
    {
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
                'redirect_uri' => urlencode($data['redirect_uri']),
                'uid' => $uid,
                'grant_type' => $data['clienttype'],
                'type' => 'public',
                'client_desc' => $data['clientdesc'],
                );
            Oauth::boot($this->config);
            // $result = Oauth::storage('client')->addClient($data);
            $this->redirect()->toUrl('/oauth/client/list');
            return;
        }
        $this->view()->assign('form', $form);
        $this->view()->setTemplate('client-register');        
    }

    public function listAction()
    {
        $userid = User::getUserid();
        Oauth::boot($this->config);
        $result = Oauth::storage('client')->get($userid, 'uid');
        $this->view()->assign('client', $result);d($result);
        $this->view()->setTemplate('client-registered');
    }
    public function profileAction()
    {
        $userinfo = User::getUserinfo();
        $model = Pi::model('client','oauth');
        $rowset = $model->select(array('uid' => $userinfo['id']));
        if (empty($rowset)) {
            $data = "没有注册应用，快去<a href = '/oauth/client/register'>注册</a>吧";
        } else {
            $data = $rowset->toArray();
        }
        $this->view()->assign('data',$data);
        $this->view()->setTemplate('client-profile');
    }

    public function editprofileAction()
    {
        $userinfo = User::getUserinfo();
        $form = new ClientRegisterForm();
        $cid = $this->params('cid','');
        $form->setAttribute('action', $this->url('', array('action' => 'editprofile','cid'=>$cid)));
        $this->view()->assign('form', $form);
        $model = Pi::model('client', 'oauth');
        if ($cid) {
            $row = $model->select(array('cid' => $cid));
            $rowdata = $row->toArray();
            if (is_array($rowdata) && $userinfo['id'] == $rowdata[0]['uid']) {
                $form->setData(array('clientname' => $rowdata[0]['cname'], 'redirect_uri' => $rowdata[0]['redirect_uri'] ));            
            }
        }
        if ($this->request->ispost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            $form->setInputFilter(new ClientRegisterFilter);
            if(!$form->isValid()) {
                $this->view()->assign('form', $form);
            } else {
                $data = $form->getData();
                $data = array(
                    'cname' => $data['clientname'],
                    'redirect_uri' => $data['redirect_uri'],
                );
                $model->update($data,array('cid'=>$cid));
            }
        }
        
        $this->view()->setTemplate('client-profileedit');
    }
}