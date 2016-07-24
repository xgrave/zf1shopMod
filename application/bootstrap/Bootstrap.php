<?php

/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/20/16
 * Time: 2:23 PM
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public $frontController;

    protected function _initLogging()
    {
        $this->bootstrap('frontController');
        $logger = new Zend_Log();

        $writer = 'production' == $this->getEnvironment() ?
            new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../data/logs/app.log') : new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);

        if('production' == $this->getEnvironment()){
            $filter = new Zend_Log_Filter_Priority(
                        Zend_Log::CRIT
            );
            $logger->addFilter($filter);
        }
        $this->_logger = $logger; //what does this refer to?
        Zend_Registry::set('log', $logger);
    }

    protected function _initDefaultModuleAutoloader()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);

        $this->_resourceLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Storefront',
            'basePath'  => APPLICATION_PATH . '/modules/storefront',
        ));
        $this->_resourceLoader->addResourceTypes(array(
            'modelResource' => array(
                'path'      => 'models/resources',
                'namespace' => 'Resource',
            )
        ));

    }

    protected function _initDbProfiler()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);
        if ('production' !== $this->getEnvironment()){
            $this->bootstrap('db');
            $profiler = new Zend_Db_Profiler_Firebug(
                'All DB Queries'
            );
            $profiler->setEnabled(true);
            $this->getPluginResource('db')
                ->getDbAdapter()
                ->setProfiler($profiler);
        }
    }

    protected function _initLocale()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);
        $locale = new Zend_Locale('en_US');
        Zend_Registry::set('Zend_Locale', $locale);

    }

    protected function _initViewSettings()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);
        $this->bootstrap('view');

        $this->_view = $this->getResource('view');

        // set encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('XHTML1_STRICT');

        // set the content type and language
        $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'en-US');

        //set css links
        $this->_view->headStyle()->setStyle('@import "/css/access.css";');
        $this->_view->headLink()->appendStylesheet('/css/reset.css');
        $this->_view->headLink()->appendStylesheet('/css/main.css');
        $this->_view->headLink()->appendStylesheet('/css/form.css');

        //Set the site title
        $this->_view->headTitle('Storefront');

        //Set separator string for segments
        $this->_view->headTitle()->setSeparator(' - ');
    }

    protected function _initRoutes()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);
        $this->bootstrap('frontController');

        $router = $this->frontController->getRouter();

        //catalog category product route
        $route = new Zend_Controller_Router_Route(
            'catalog/:categoryIdent/:productIdent',
            array(
                'action'        => 'view',
                'controller'    => 'catalog',
                'module'        => 'storefront',
                'categoryIdent' => '',
            ),
            array(
                'categoryIdent' => '[a-zA-Z-_0-9]+',
                'productIdent' => '[a-zA-Z-_0-9]+'
            )
        );
        $router->addRoute('catalog_category_product', $route);

        // catalog category route
        $route = new Zend_Controller_Router_Route(
            'catalog/:categoryIdent/:page',
            array(
                'action'        => 'index',
                'controller'    => 'catalog',
                'module'        => 'storefront',
                'categoryIdent' => '',
                'page'          => 1
            ),
            array(
                'categoryIdent' => '[a-zA-Z-_0-9]+',
                'page'          => '\d+'
            )
        );

        $router->addRoute('catalog_category', $route);

    }
}