<?php

namespace Posts;

return array(
    'controllers' => array(
        'invokables' => array(
            'Posts\Controller\Index' => 'Posts\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'posts' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/posts/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Posts\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),

                'may_terminate' => true,

                'child_routes' => array(
                    'default' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[:controller/[:action/[:id/]]]',
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