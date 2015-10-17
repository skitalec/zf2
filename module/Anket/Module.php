<?php

namespace Anket;

use Anket\Model\AnketTable;

use Zend\ServiceManager\ServiceManager;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class Module
{

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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Anket\Model\AnketTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new AnketTable($dbAdapter);
                    return $table;
                },
            ),

            'mail.transport' => function (ServiceManager $serviceManager) {
                $config = $serviceManager->get('Config');
                $transport = new Smtp();
                $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
                return $transport;
            },

        );
    }
}