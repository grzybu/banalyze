<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->setLayout('auth');
    }

    public function indexAction()
    {
        $this->_helper->redirector('login');
    }

    public function loginAction()
    {
        $form = new Application_Form_Login();

        if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams()) && $form->getValues())
        {
            $user = new BApp_Model_User();
            if($user->login($form->getValue('username'), $form->getValue('password'))) {
                $this->_redirect("/");
            }else {
                $form->populate($this->getRequest()->getParams());
                $form->setErrorMessages(array("Błędne dane logowania"));
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('login');
    }


}





