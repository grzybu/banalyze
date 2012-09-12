<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 04.09.12
 * Time: 22:31
 * To change this template use File | Settings | File Templates.
 */
class BApp_Model_User
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function login($login, $password)
    {
       $dbAdapter = Zend_Db_Table::getDefaultAdapter();

       /*
        * set-up adaptera
        */
       $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
       $authAdapter->setTableName('users')
                   ->setIdentityColumn('login')
                   ->setCredentialColumn('password')
                   ->setIdentity($login)
                   ->setCredential($password);

       //hasła w bazie przechowywane jest jako hash SHA1 hasla i salta zapisanego w aplikacji


       $authAdapter->setCredentialTreatment("SHA1(CONCAT('"
           . Zend_Registry::get('appSalt')
           . "', ?, salt))");

        $authAdapter->getDbSelect()->where("active = ?", self::STATUS_ACTIVE);


        //Autentykacja
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        if (!$result->isValid()) {
            //failed login
            return false;
        }

        //get the matching row and persist to session
        $row = $authAdapter->getResultRowObject(array(
            'id',
            'role',
            'login',
        ));
        $auth->getStorage()->write($row);

        //login successful
        return true;

    }
}
