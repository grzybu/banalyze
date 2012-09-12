<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 11.09.12
 * Time: 23:31
 * To change this template use File | Settings | File Templates.
 */
class Application_Model_Result extends Application_Model_AbstractModel
{

    protected $_dbTableName = 'Results';

    /* @var Application_Model_Patient contains Patient object */
    protected $_patient;


    /**
     * @param \Application_Model_Patient $patient
     */
    public function setPatient($patient)
    {
        $this->_patient = $patient;
    }

    /**
     * @return \Application_Model_Patient
     */
    public function getPatient()
    {
        return $this->_patient;
    }


}
