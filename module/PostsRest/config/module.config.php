<?php

namespace PostsRest;

return array(
    'controllers' => array(
        'invokables' => array(
            'PostsRest\Controller\PostsRest' => 'PostsRest\Controller\PostsRestController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'posts-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/posts-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PostsRest\Controller\PostsRest',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

);