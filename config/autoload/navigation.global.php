<?php

return array(
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),

            array(
                'label' => 'Войти',
                'route' => 'myauth',
                'controller' => 'index',
                'action' => 'login',
            ),

            array(
                'label' => 'Анкета1',
                'uri' => 'http://localhost/zend/anket/anket/add/type/1',
            ),

            array(
                'label' => 'Анкета2',
                'uri' => 'http://localhost/zend/anket/anket/add/type/2',
            ),

            array(
                'label' => 'Анкета3',
                'uri' => 'http://localhost/zend/anket/anket/add/type/3',
            ),

            array(
                'label' => 'Анкета4',
                'uri' => 'http://localhost/zend/anket/anket/add/type/4',
            ),

            array(
                'label' => 'Список Анкет',
                'route' => 'anket',
                'controller' => 'anket',
                'action' => 'user',
                'privilege' => 'login',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
);