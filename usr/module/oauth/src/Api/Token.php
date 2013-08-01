<?php
namespace Module\Oauth\Api;

use Pi;
use Pi\Application\AbstractApi;



/**
* for the resource server module , server about Token
* 
*  method : chekcToken($token)
*  code of use:
*   ~~~
*    Pi::service('api')->oauth(array('token', 'checkToken'), $token);
*   ~~~
*/

class Token extends AbstractApi
{
    protected $module = 'oauth';


    /**
    * check token's validate and return token info if valid
    *
    * @param $token : access_token
    *
    * @return array  ,array('statue' => '1|0' , 'data' => tokenDataArray|errorMessageString);
    */
    public function checkToken($token)
    {
        $row = Pi::model('access_token', $this->getModule())->find($token, 'token');
        $statue = 0;
        if (!$row) {
            $result = 'wrong token';
        } else {
            $data = $row->toArray();
            if (time() > $data['expires']) {
                $result = "token has expired";
            } else {
                $statue = 1;
                $result = array(
                    'uid' => $data['resource_owner'],
                    'scope' => $data['scope'],
                );
            }
        }
        return array(
            'statue' => $statue,
            'data'   => $result,
        );
    }
}