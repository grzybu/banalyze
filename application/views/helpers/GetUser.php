<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 23.09.12
 * Time: 16:58
 * To change this template use File | Settings | File Templates.
 */
class Zend_View_Helper_GetUser extends Zend_View_Helper_Abstract
{
    public function getUser()
    {
        if(Zend_Auth::getInstance()->hasIdentity()){
            return Zend_Auth::getInstance()->getIdentity();
        }
        return nul;
    }

}
