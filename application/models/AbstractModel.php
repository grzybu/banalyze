<?php

class Application_Model_AbstractModel
{
    /* @var Zend_Db_Table_Abstract */
    protected $_dbTable;


    /* @var string dbtable name */
    protected $_dbTableName = '';

    function __construct()
    {
        if(!$this->_dbTableName ) throw new Exception('dbTableName musi być ustawione');

        $dbTableClass = "Application_Model_DbTable_" . ucfirst($this->_dbTableName);

        if(!class_exists($dbTableClass)) throw new Exception("Klasa {$dbTableClass} nie istnieje");

        $this->setDbTable(new $dbTableClass);
    }


    /**
     * @param \Zend_Db_Table_Abstract $dbTable
     */
    public function setDbTable($dbTable)
    {
        $this->_dbTable = $dbTable;
    }

    /**
     * @return \Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        return $this->_dbTable;
    }

    /**
     * @param string $dbTableName
     */
    public function setDbTableName($dbTableName)
    {
        $this->_dbTableName = $dbTableName;
    }

    /**
     * @return string
     */
    public function getDbTableName()
    {
        return $this->_dbTableName;
    }

    public function save()
    {
        $table  = $this->getDbTable();

        $properties = $this->toArray();

        $tableCols = $this->getDbTable()->info(Zend_Db_Table_Abstract::COLS);

        $data = array();

        $id = isset($this->_id) ? $this->_id : null;

        foreach($properties as $key=>$val)
        {
                $propertyKey = ltrim($key, "_");
            if(in_array($propertyKey, $tableCols)) {
                $data[$propertyKey] = $val;
            }


        }



        //insert
        if(null == $id) {
            unset($data['id']);

            $id = $table->insert($data);
            $this->_id = $id;
        }



        return $this->_id;

    }

    public function toArray()
    {
        $properties = get_object_vars($this);
#Zend_Debug::dump($properties);exit;
        $data = array();

        foreach($properties as $key => $p)
        {
           # Zend_Debug::dump((is_string($key) && strpos($key, "_db") == 0 ) || is_object($p), $key);
            if((is_string($key) && strpos($key, "_db") === 0 ) || is_object($p)) {

                unset($properties[$key]);
            }
            else {

                $data[$key] = $this->$key;
            }


        }


       return $data;
    }


}

