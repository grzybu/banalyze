<?php

class Analyze_BloodtestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $form = new Application_Form_Analize();
       $this->view->form = $form;
    }

    public function generateRandomAction()
    {

            foreach (array("M", "K") as $sex) {
                foreach(range(18,74) as $age) {




                    $hgb = new Application_Model_Hemoglobin();


                    $p1 = $hgb->generatePopulation($sex, $age);


                    $hct = new Application_Model_Hematocrit();
                    $p2 = $hct->generatePopulation($sex, $age);
                    $rbc = new Application_Model_RedBloodCell();
                    $p3 = $rbc->generatePopulation($sex, $age);
                    $wbc = new Application_Model_WhiteBloodCell();
                    $p4 = $wbc->generatePopulation($sex, $age);

                    for ($i = 0; $i < 20; $i++) {
                        $patient = new Application_Model_Patient();
                        $patient = $patient->createNewPatient($sex, $age);

                        $result = new Application_Model_Result();
                        $result->setPatient($patient);


                        $result->setHgb($hgb->getRandomValue($patient->getSex(), $patient->getAge(), 10000, $p1));
                        $result->setHct($hct->getRandomValue($patient->getSex(), $patient->getAge(), 10000, $p2));
                        $result->setRbc($rbc->getRandomValue($patient->getSex(), $patient->getAge(), 10000, $p3));
                        $result->setWbc($wbc->getRandomValue($patient->getSex(), $patient->getAge(), 10000, $p4));
                        $result->setMchc($result->calcMCHC($result->getHgb(), $result->getHct()));
                        $result->setMcv($result->calcMCV($result->getHct(), $result->getRbc()));
                        $result->setMch($result->calcMCH($result->getHgb(), $result->getRbc()));


                        $result->save();

                    }
                }
            }


            exit;





    }

    public function korelacjeAction()
    {

        $form = new Application_Form_Corelations();


        if($this->getRequest()->isPost() && $form->isValid($_POST) && $form->getValues()) {
            $results = new Application_Model_Result();
            $results = $results->getBySex($form->getValue('sex'), $form->getValue('n'));
            $X = array();
            $Y = array();

            $param1 = $form->getValue('param1');
            $param2 = $form->getValue('param2');
           foreach($results as $r) {
               $X[] = $r->$param1;
               $Y[] = $r->$param2;
           }
            $this->view->n = count($results);
            $p = new BApp_Pearson();

            $this->view->mx = array_sum($X)/count($X);
            $this->view->my = array_sum($Y)/count($Y);

           $p1 = $form->getElement('param1')->getMultiOptions();
            $this->view->param1 = $p1[$param1];

            $p2 = $form->getElement('param2')->getMultiOptions();
            $this->view->param2 = $p2[$param2];

            $this->view->r = round($p->countPearsonCorrelationCoefficient($X, $Y),3);

        }

        $this->view->form  = $form;



      /*  $rs = $results->getDefaultAdapter()->fetchPairs("SELECT hgb, mch FROM `results`
left JOIN patients on patient_id  = patients.id

where sex = 'M'
order by rand()
limit 10000 ");
        $X = array();
        $Y = array();

        foreach($rs  as $x=>$y) {
            $X[] = $x;
            $Y[] = $y;
        }




    Zend_Debug::dump($X);
        Zend_Debug::dump($Y);



        Zend_Debug::dump($p->countPearsonCorrelationCoefficient($X,$Y));*/
    }


    public function normalizeHctAction()
    {
         $db = new Application_Model_DbTable_Results();
         $rs = $db->fetchAll();

         foreach($rs  as $row) {
            $x = $row->hgb;
        $rand = mt_rand(1,4);
        if($rand == 1) {
            $row->hct = $x*2.95;
        }elseif($rand == 2){
            $row->hct = 2.8*$x+0.8;
        }elseif($rand == 3) {
            $row->hct = 2.941*$x;
        }else {
            $row->hct = ($x*0.62058*0.0485+0.0083)*100;
        }
             $row->save();
    }

        exit;
    }

    public function benchmarkAction()
    {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $pearson = new BApp_Pearson();
        $n = 1000;
        $pop = $this->_getPopulation('mcv', 'hct', $n);
        $pearson->countPearsonCorrelationCoefficient($pop[0], $pop[1]);

    }

    public function testPearsonAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $pearson = new BApp_Pearson();
        print "Test wyznaczania korelacji\n";
        $array = array_merge(range(10, 90, 10),range(100, 1000, 100), range(1250, 2000, 250), range(2500, 7000, 500));

        foreach($array as $n) {

                $time_start = microtime(true);
                 $pop = $this->_getPopulation('hgb', 'hct', $n);
                $time_end = microtime(true);
                $db_time = $time_end - $time_start;


                $time_start = microtime(true);
                 $r = $pearson->countPearsonCorrelationCoefficient($pop[0], $pop[1]);
                $time_end = microtime(true);
                $p_time = $time_end - $time_start;


                $time_end = microtime(true);
                $time = $time_end - $time_start;

                unset($pop);
                print "{$n};{$db_time};{$p_time}\n";


        }
    }

    private function _getPopulation($param1, $param2, $n, $sex = null) {
        $results = new Application_Model_Result();


        $rs = $results->getBySex($sex, $n);

        $X = array();
        $Y = array();


        foreach($rs as $r) {
            $X[] = $r->$param1;
            $Y[] = $r->$param2;
        }

        return array($X, $Y);

    }


}



