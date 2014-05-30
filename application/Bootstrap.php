<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initConfig() {
        
        $config = new Zend_Config($this->getOptions());
		Zend_Registry::set('config', $config);

    }
    
	protected function _initAutoLoader() {
        
		$autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace("Momesso");
        $autoloader->registerNamespace("EasyBib");
        
        $autoloader->autoload('Momesso_Plugins_WideImage_WideImage');
        $autoloader->autoload('Momesso_Plugins_PHPExcel_Classes_PHPExcel');
        $autoloader->autoload('Momesso_Plugins_Boleto_Boleto');
        $autoloader->autoload('Momesso_Plugins_MPDF53_mpdf');
        
        return $autoloader;
    }
    
    protected function _initPlaceholders() {
    	
        $this->bootstrap('View');
    	$view = $this->getResource('View');
    	$view->doctype('HTML5');
    
    	$title = Zend_Registry::get('config');
    	$view->headTitle($title->projectName)->setSeparator(' - ');
    
    	//$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
    	//$view->jQuery()->enable();
    	//$view->jQuery()->uiEnable();
    }
    
    protected function _initCache() {
    	$front = array('automatic_serialization' => true);
    	$back = array('cache_dir' => APPLICATION_PATH . '/../tmp');
    	$cache = Zend_Cache::factory('Core', 'File', $front, $back);
    	Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
    }

    /*protected function _initTranslate() {
    	$translate = new Zend_Translate('array', APPLICATION_PATH . '/../languages/pt_BR/Zend_Validate.php', 'pt_BR');
    	Zend_Registry::set('Zend_Translate', $translate);
    }*/
    
	protected function _initDb() {
            $options = $this->getOption('resources');
            $db = Zend_Db::factory($options['db']['adapter'], $options['db']['params']);
            Zend_Db_Table_Abstract::setDefaultAdapter($db);
            $db->getConnection();
            Zend_Registry::set('db', $db);

            $front = array('automatic_serialization' => true);
            $back = array('cache_dir' => '../tmp');
            $cache = Zend_Cache::factory('Core', 'File', $front, $back);
            Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
	}

	protected function _initPlugins() {
        
       $front = Zend_Controller_Front::getInstance();
		
        $front->registerPlugin(new Momesso_Plugins_Layout())
                ->registerPlugin(new Momesso_Plugins_Acl())
                ->registerPlugin(new Momesso_Plugins_Auth())
                ->registerPlugin(new Momesso_Plugins_Banner())
                ->registerPlugin(new Momesso_Plugins_ApagaDiretorio());
    }
    
    protected function _initAutoload() {
    	$moduleLoader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => '',
    			'basePath' => APPLICATION_PATH)
    	);
    	return $moduleLoader;
    }
    
	public function _initRoutes() {
	
    	$this->bootstrap('FrontController');
    	$this->_frontController = $this->getResource('FrontController');
    	$router = $this->_frontController->getRouter();

    	$route = new Zend_Controller_Router_Route(
    			'language/:lang',
    			array(
    					'module' => 'default',
    					'controller' => 'language',
    					'action'     => 'index'
    			)
    	);
    	$router->addRoute('language', $route);
    	
    	$route = new Zend_Controller_Router_Route(
    			'a-electric-ink',
    			array(
    					'module' => 'default',
    					'controller' => 'empresa',
    					'action'     => 'index'
    			)
    	);
    	$router->addRoute('empresa', $route);
    	
    	$route = new Zend_Controller_Router_Route_Regex(
    			'produto/category/(.+)/(.+)',
    			array(
    					'module' => 'default',
    					'controller' => 'produto',
    					'action'     => 'category'
    			),
    			array(
    					1 => 'nome',
    					2 => 'id'
    			)
    	);
    	$router->addRoute('produto', $route);
    	
        $route = new Zend_Controller_Router_Route_Regex(
                'produto/grupo/(.+)/(.+)',
                array(
                        'module' => 'default',
                        'controller' => 'produto',
                        'action'     => 'grupo'
                ),
                array(
                        1 => 'nome',
                        2 => 'id'
                )
        );
        $router->addRoute('produtogrupo', $route);


    	$route = new Zend_Controller_Router_Route_Regex(
    			'produto/view/(.+)-(.+)',
    			array(
    					'module' => 'default',
    					'controller' => 'produto',
    					'action'     => 'view'
    			),
    			array(
    					1 => 'nome',
    					2 => 'id'
    			)
    	);
    	$router->addRoute('produtoview', $route);
    	
    	$route = new Zend_Controller_Router_Route_Regex(
    			'noticia/view/(.+)-(.+)',
    			array(
    					'module' => 'default',
    					'controller' => 'noticia',
    					'action'     => 'view'
    			),
    			array(
    					1 => 'nome',
    					2 => 'id'
    			)
    	);
    	$router->addRoute('noticia', $route);
    	
    	$route = new Zend_Controller_Router_Route_Regex(
    			'tatuador/view/(.+)-(.+)',
    			array(
    					'module' => 'default',
    					'controller' => 'tatuador',
    					'action'     => 'view'
    			),
    			array(
    					1 => 'nome',
    					2 => 'id'
    			)
    	);
    	$router->addRoute('tatuador', $route);

	}
    
	protected function _initLocale() {
		
     $session = new Zend_Session_Namespace('ttb.l10n');
     
     if ($session->locale)  {
     	
        $locale = new Zend_Locale($session->locale);   
     }
     
     if (!isset($locale)) {
        
     	try {
        	
        	$locale = new Zend_Locale('browser');
        
     	} catch (Zend_Locale_Exception $e) {
        	
          	$locale = new Zend_Locale('pt_BR');
        }

     }

     Zend_Registry::set('Zend_Locale',$locale->getLanguage());
  }
    
    public function _initTranslatee() {
    	 
    	$translate = new Zend_Translate('array',
                  APPLICATION_PATH . '/../languages/',
                  null,
                  array('scan' => Zend_Translate::LOCALE_FILENAME,
                        'disableNotices' => 1));
    	
	    Zend_Registry::set('Zend_Translate', $translate);

        $zend_validate = new Zend_Translate('array', APPLICATION_PATH . '/../languages/'.Zend_Registry::get('Zend_Locale').'/Zend_Validate.php', Zend_Registry::get('Zend_Locale'));

        Zend_Form::setDefaultTranslator($zend_validate);

    }

}

