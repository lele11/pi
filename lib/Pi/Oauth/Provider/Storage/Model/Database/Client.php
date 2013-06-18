<?php
namespace Pi\Oauth\Provider\Storage\Model\Database;

use Pi\Oauth\Provider\Storage\ValidateInterface;
use Pi\Oauth\Provider\Storage\Model\Database\AbstractModel;

class Client extends AbstractModel implements ValidateInterface
{
    public function validate($id, $secret)
    {
        $rowset = $this->model->select(array(
            'client_id'     => $id,
            'client_secret' => $secret,
        ));
        return $rowset->count() == 1 ? true : false;
    }

    public function addClient($client)
    {
        $row = $this->model->find($client['client_id'],'client_id');d($row);
        if (!$row) {
            return $this->add($client);
        }
        return null;
    }

    public function getClient($clientid)
    {
        return $this->get($clientid,'client_id');
    }
}