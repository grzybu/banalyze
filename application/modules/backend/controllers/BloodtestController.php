<?php

class Backend_BloodtestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    }

    public function importAction()
    {
        $form = new Application_Form_ImportResult();

        if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams()) && $form->getValues()) {
            if(!$form->getElement('image_file')->receive()) {
                $form->getElement('image_file')->addError('Błąd wczytywania pliku');
                return;
            }

         $image = $form->getElement('image_file')->getFileName();
         $ocrSdk = new Abby_OcrSdk();
         $ocrSdk->setApplicationId('bloodtestDataImport');
         $ocrSdk->setPassword('K/ulkeOWOZF9qXfayL6U2011');



          if(!file_exists($image)) {
               throw new Exception("Brak pliku");
           }




        $taskId = $ocrSdk->processImage($image);

        $status = "";
        $counter = 10;
        do {
            sleep(5);
            $taskStatus  = $ocrSdk->getTaskStatus($taskId);

            $status = is_array($taskStatus) ? $taskStatus['status'] : $taskStatus;
            $counter--;

        }while($status != "Complete" || $counter > 0);

            $url = $taskStatus['resultUrl'];
            Zend_Debug::dump($url);exit;


        }

        $this->view->form = $form;


    }

    public function listTasksAction()
    {
        $ocrSdk = new Abby_OcrSdk();
        $ocrSdk->setApplicationId('bloodtestDataImport');
        $ocrSdk->setPassword('K/ulkeOWOZF9qXfayL6U2011');

        $tasks = $ocrSdk->listTasks();
        $adapter = new Zend_Paginator_Adapter_Array($tasks);
        $paginator = new Zend_Paginator($adapter);

        $this->view->paginator = $paginator;




    }


}





