<?php

class Application_Model_DbTable_Patients extends Zend_Db_Table_Abstract
{

    protected $_name = 'patients';

    public function add($uq_patient_id, $year_of_birth, $sex)
    {
        $data = array(
            'uq_patient_id' => $uq_patient_id,
            'year_of_birth' => $year_of_birth,
            'sex' => $sex

        );

        try {
          return  $this->insert($data);
        }catch (Exception $e)
        {
            print $e->getMessage();
            Zend_Debug::dump($data);exit;

        }
    }


}

