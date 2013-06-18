<?php
namespace Pi\Oauth\Provider\Storage\Model\Database;

use Pi\Oauth\Provider\Storage\ValidateInterface;
use Pi\Oauth\Provider\Storage\Model\Database\AbstractModel;

class AuthorizationCode extends AbstractModel implements ValidateInterface
{
    public function validate($id, $secret)
    {

    }
}
