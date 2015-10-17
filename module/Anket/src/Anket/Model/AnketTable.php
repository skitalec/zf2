<?php

namespace Anket\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class AnketTable extends AbstractTableGateway
{
    protected $table = 'anket';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Anket());

        $this->initialize();
    }

    public function fetchAll(Select $select = null, $type = null)
    {
        if (null === $select)
            $select = new Select();
        $select->from($this->table);
        if ($type != null) {
            $select->where(array('name_anket' => $type));
        }
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }


    public function getAnket($id)
    {
        $id = (int)$id;

        $rowset = $this->select(array(
            'id' => $id,
        ));

        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveAnket(Anket $anket)
    {
        $data = array(
            'name' => $anket->name,
            'phone' => $anket->phone,
            'email' => $anket->email,
            'type_equipment' => $anket->type_equipment,
            'comments' => $anket->comments,
            'call_back' => $anket->call_back,
            'name_anket' => $anket->name_anket,
        );

        $date = new \DateTime();
        $data['date'] = $date->format('Y-m-d H:i:s');
        $this->update($data, array('date' => $date->format('Y-m-d H:i:s')));

        $id = (int)$anket->id;

        if ($id == 0) {
            $this->insert($data);
        } elseif ($this->getAnket($id)) {
            $this->update($data, array('id' => $id,));
        } else {
            throw new \Exception('Form id does not exist');
        }

    }

    public function deleteAnket($id)
    {
        $this->delete(array('id' => $id,));
    }

    public function resultAnket()
    {
        $sql = "SELECT  `name_anket` , COUNT( * ) as count
                FROM  `anket`
                WHERE 1
                GROUP BY  `name_anket` ";

        $sql_result = $this->adapter->createStatement($sql, array(125000, 125200))->execute();
        if ($sql_result->count() > 0) {
            $results = new ResultSet();
            $data = $results->initialize($sql_result)->toArray();
        }
        $result = array();
        foreach ($data as $value) {

            $result[$value['name_anket']] = $value['count'];
        }
        //echo'<pre>'; print_r($result);echo'</pre>';die;
        return $result;

    }
}


