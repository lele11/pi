<?php
namespace Pi\Oauth\Provider\Storage;

class AccessToken extends AbstractStorage implements CodeInterface
{
    public function add($params)
    {
        if (!isset($params['token'])) {
            $params['token'] = $this->generateCode($this->config['length']);
        }

        $tokenData = $this->model->getToken($params);
        if (empty($tokenData)) {
            parent::add($params);
        }
        
        return array(
            'token_type'    => $this->config['token_type'],
            'expires_in'    => $this->config['expires'],
            'access_token'  => $params['token'],
        );
    }
}