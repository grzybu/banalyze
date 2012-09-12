<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

       /* $patient = new Application_Model_DbTable_Patients();
        $sex = array("K", "M");
        Zend_Debug::dump($patient->add(strtoupper(uniqid("P")), rand(1912, date("Y")) ,$sex[array_rand($sex)] )); */

        $patient = new Application_Model_Patient();
        $patient = $patient->createNewPatient();
       Zend_Debug::dump($patient);
    }


}

