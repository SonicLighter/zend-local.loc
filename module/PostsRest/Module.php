<?php
namespace PostsRest;

class Module
{
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

    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('render', array($this, 'registerJsonStrategy'), 100);
    }

    /**
     * @param  \Zend\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function registerJsonStrategy(\Zend\Mvc\MvcEvent $e) {
        $matches    = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        if (false === strpos($controller, __NAMESPACE__)) {
            // not a controller from this module
            return;
        }

        $model = $e->getResult();

        if($model instanceof \Zend\View\Model\ViewModel)
        {
            $newModel = new \Zend\View\Model\JsonModel($model->getVariables());
            //$e->setResult($newModel);
            $e->setViewModel($newModel);
        }
    }
}
