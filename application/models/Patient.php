<?php

class Application_Model_Patient extends Application_Model_AbstractModel
{
    protected $_dbTableName = 'patients';

    const PATIENT_SEX_K = 'K';
    const PATIENT_SEX_M = 'M';

    protected $_id;
    protected $_uq_patient_id;
    protected $_year_of_birth;
    protected $_sex;
    protected $_add_date = null;

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ( !method_exists ($this, $method)) {
            throw new Exception('Invalid  property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ( !method_exists ($this, $method)) {
            throw new Exception('Invalid  property');
        }
        return $this->$method();
    }

    public function setAddDate($add_date)
    {
        $this->_add_date = $add_date;
    }

    public function getAddDate()
    {
        return $this->_add_date;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setSex($sex)
    {
        $this->_sex = $sex;
    }

    public function getSex()
    {
        return $this->_sex;
    }

    public function setUqPatientId($uq_patient_id)
    {
        $this->_uq_patient_id = $uq_patient_id;
    }

    public function getUqPatientId()
    {
        return $this->_uq_patient_id;
    }

    public function setYearOfBirth($year_of_birth)
    {
        $this->_year_of_birth = $year_of_birth;
    }

    public function getYearOfBirth()
    {
        return $this->_year_of_birth;
    }


    public function createNewPatient()
    {
        $this->setUqPatientId(strtoupper(uniqid("P")));

        $sex = array(self::PATIENT_SEX_K, self::PATIENT_SEX_M);

        $this->setSex($sex[array_rand($sex)]);
        $this->setYearOfBirth(rand(18,74));


        $this->save();
        return $this;


    }

    public function getAge()
    {
        return floor( (strtotime(date('Y-m-d')) - strtotime($this->_year_of_birth)) / 31556926);
    }


}

