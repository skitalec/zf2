<?php

namespace MyAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use MyAuth\Model\Auth;
use MyAuth\Form\AuthForm;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        $user = $this->identity();
        $form = new AuthForm();
        $form->get('submit')->setValue('Войти');
        $messages = null;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $authFormFilters = new Auth();
            $form->setInputFilter($authFormFilters->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $sm = $this->getServiceLocator();
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

                $config = $this->getServiceLocator()->get('Config');
                $staticSalt = $config['static_salt'];

                $authAdapter = new AuthAdapter($dbAdapter,
                    'users',
                    'usr_email',
                    'usr_password',
                    "MD5(CONCAT('$staticSalt', ?, usr_password_salt)) AND usr_active = 1" // setCredentialTreatment(parametrized string) 'MD5(?)'
                );
                $authAdapter
                    ->setIdentity($data['usr_email'])
                    ->setCredential($data['usr_password']);

                $auth = new AuthenticationService();
                $result = $auth->authenticate($authAdapter);

                switch ($result->getCode()) {
                    case Result::FAILURE_IDENTITY_NOT_FOUND:
                        break;
                    case Result::FAILURE_CREDENTIAL_INVALID:
                        break;
                    case Result::SUCCESS:
                        $storage = $auth->getStorage();
                        $storage->write($authAdapter->getResultRowObject(
                            null,
                            'usr_password'
                        ));
                        $time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
                        if ($data['rememberme']) {
                            $sessionManager = new \Zend\Session\SessionManager();
                            $sessionManager->rememberMe($time);
                        }
                        break;
                    default:
                        break;
                }
                foreach ($result->getMessages() as $message) {
                    $messages .= "$message\n";
                }
            }
        }
        return new ViewModel(array('form' => $form, 'messages' => $messages));
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
        }

        $auth->clearIdentity();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();

        return $this->redirect()->toRoute('myauth', array('controller' => 'index', 'action' => 'login'));
    }

}