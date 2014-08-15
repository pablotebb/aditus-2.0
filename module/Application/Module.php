<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    // unauthenticated whitelist
    private $_whitelist = array(
        'login' ,
        'register' ,
    );

    /*
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    */

    public function onBootstrap(MvcEvent $e)
    {

        $eventManager = $e->getApplication()->getEventManager();

        // check if the user is still logged in before routing
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'authPreDispatch'), 100);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * [authPreDispatch]
     *
    */
    public function authPreDispatch($event)
    {
        return;
        $authenticationService = $event->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService');
        $loggedUser = $authenticationService->getIdentity();
        $routeMatch = $event->getRouteMatch();

        /*
        *  This is the routing to other functions that are whitelisted.
        *
        */
        if ($authenticationService->hasIdentity() == false &&
            in_array($routeMatch->getMatchedRouteName(), $this->_whitelist) == false) {
            $url = $event->getRouter()->assemble(array('action' => 'login'), array('name' => 'login'));
            $response = $event->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit;
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
