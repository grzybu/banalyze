<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 06.09.12
 * Time: 17:27
 * To change this template use File | Settings | File Templates.
 */
class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $user = Zend_Auth::getInstance()->getIdentity();
        if(null == $user && $request->getControllerName() !== 'auth')
        {
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoUrl('/auth/login');
        }
    }
}
