<?php

namespace Error;

use Zend\ModuleManager\Feature;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ServiceProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\BootstrapListenerInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfiguration()
    {
        return include __DIR__ . '/config/services.config.php';
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        $app = $e->getParam('application');
        $sm  = $app->getServiceManager();
        $em  = $app->getEventManager();

        $listener = $sm->get('ErrorExceptionListener');
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, $listener, 10);
    }
}
