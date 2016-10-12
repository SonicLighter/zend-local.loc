<?php

namespace Vk;

return array(
    'controllers' => array(
        'invokables' => array(
            'Vk\Controller\Index' => 'Vk\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'vk' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/vk/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vk\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),

                'may_terminate' => true,

                'child_routes' => array(
                    'default' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[:controller/[:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),

            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'display_exceptions' => true,
    ),

);