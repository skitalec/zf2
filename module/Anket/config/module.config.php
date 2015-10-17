<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Anket\Controller\Anket' => 'Anket\Controller\AnketController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'anket' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/anket[/:controller][/:action][/:id][/page/:page][/type/:type][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[0-9]+',
                        'type' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Anket\Controller',
                        'controller' => 'Anket\Controller\Anket',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'anket' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator' => __DIR__ . '/../view/layout/Paginator.phtml',
        ),
    ),
);