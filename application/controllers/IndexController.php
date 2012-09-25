<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $hemo = new Application_Model_Hematocrit();
        Zend_Debug::dump($hemo->getRandomValue('K', 21, 10000), "hct");
        $hgb = new Application_Model_Hemoglobin();
        Zend_Debug::dump($hgb->getRandomValue('K', 21, 10000), "hgb");
        $rbc = new Application_Model_RedBloodCell();
        Zend_Debug::dump($rbc->getRandomValue('M', 23, 1000), "rbc");
        $wbc = new Application_Model_WhiteBloodCell();
        Zend_Debug::dump($wbc->getRandomValue("K", 22, 10000), "wbc");
    }


}

