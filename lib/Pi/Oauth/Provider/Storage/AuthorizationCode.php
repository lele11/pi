<?php
namespace Pi\Oauth\Provider\Storage;

class AuthorizationCode extends AbstractStorage implements CodeInterface
{
    public function add($params)
    {
        if (!isset($params['code'])) {
            $params['code'] = $this->generateCode($this->config['length']);
        }
        parent::add($params);
        return $params['code'];
    }

    /**
    * generate auth code ,and length of code could be defined in config array
    * @return string
    */
    public function generateCode($length = null)
    {
        return md5(rand());
    }

    /**
    * make a authorization code expired 
    */
    public function expire($expires = null)
    {

    }
}