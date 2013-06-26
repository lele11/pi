<?php
namespace Module\Oauth\Api;

use Pi;
use Pi\Application\AbstractApi;
use Pi\Db\RowGateway\RowGateway;

class Authorize extends AbstractApi
{
    public function authorize($params)
    {
        $authorize = 'https://' . $host . 'oauth/authorize/index' . $this->buildUri($params);
        
    }

    /**
    * build authorization url 
    */
    protected function buildUri($params)
    {
        foreach ($params as $key => $value) {
            $uri = '/' . $key . '-' . $value;
        }
        return $uri;
    }


}