<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MyAuth\Controller\Index' => 'MyAuth\Controller\IndexController',
            'MyAuth\Controller\Registration' => 'MyAuth\Controller\RegistrationController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'myauth' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/myauth[/:controller][/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_.-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'MyAuth\Controller',
                        'controller' => 'Index',
                        'action' => 'login',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'myauth' => __DIR__ . '/../view',
        ),

        // 'display_exceptions' => true,
    ),

    'service_manager' => array(
        // added for Authentication and Authorization. Without this each time we have to create a new instance.
        // This code should be moved to a module to allow Doctrine to overwrite it
        'aliases' => array( // !!! aliases not alias
            'Zend\Authentication\AuthenticationService' => 'my_auth_service',
        ),
        'invokables' => array(
            'my_auth_service' => 'Zend\Authentication\AuthenticationService',
        ),
    ),
);
