<?php
namespace MyAuth\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($usr_id)
    {
        $usr_id = (int)$usr_id;
        $rowset = $this->tableGateway->select(array('usr_id' => $usr_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $usr_id");
        }
        return $row;
    }

    public function getUserByToken($token)
    {
        $rowset = $this->tableGateway->select(array('usr_registration_token' => $token));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $token");
        }
        return $row;
    }

    public function activateUser($usr_id)
    {
        $data['usr_active'] = 1;
        $data['usr_email_confirmed'] = 1;
        $this->tableGateway->update($data, array('usr_id' => (int)$usr_id));
    }

    public function getUserByEmail($usr_email)
    {
        $rowset = $this->tableGateway->select(array('usr_email' => $usr_email));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $usr_email");
        }
        return $row;
    }


    public function saveUser(Auth $auth)
    {
        $data = array(
            'usr_name' => $auth->usr_name,
            'usr_password' => $auth->usr_password,
            'usr_password_salt' => $auth->usr_password_salt,
            'usr_email' => $auth->usr_email,
            'usr_email_confirmed' => $auth->usr_email_confirmed,
            'usr_active' => $auth->usr_active,
            'usr_registration_token' => $auth->usr_registration_token,
        );

        $usr_id = (int)$auth->usr_id;
        if ($usr_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($usr_id)) {
                $this->tableGateway->update($data, array('usr_id' => $usr_id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
}