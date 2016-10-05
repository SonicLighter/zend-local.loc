<?php
namespace AuthDoctrine;

use AuthDoctrine\Service\IsExistValidator;

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

    public function getServiceConfig()
    {
        return array(
//-			'aliases' => array( // !!! aliases not alias
//-				'Zend\Authentication\AuthenticationService' => 'doctrine_authenticationservice', // aliases can be overwriten
//-			),
            'factories' => array(

                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },

                'AuthDoctrine\Service\IsExistValidator' => function($serviceLocator){

                    $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $repository = $entityManager->getRepository('MyBlog\Entity\Users');

                    return new IsExistValidator($repository);

                },
            )
        );
    }
}
