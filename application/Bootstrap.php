<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoloader()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->suppressNotFoundWarnings(true);
        $autoloader->setFallbackAutoloader(true);
    }

    protected function _initZendRegistry()
    {
           $security = $this->getOption('security');
           Zend_Registry::set('appSalt', $security['appSalt']);
    }

    protected function _initZendNavigation()
    {
        $config    = new Zend_Config_Ini(APPLICATION_PATH . '/configs/navigation.ini', 'nav');
        $container = new Zend_Navigation($config);

        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        $view->navigation($container);
    }

}

