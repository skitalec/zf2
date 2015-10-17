<?php
namespace MyAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use MyAuth\Model\Auth;
use MyAuth\Form\RegistrationForm;
use MyAuth\Form\RegistrationFilter;

use Zend\Mail\Message;

class RegistrationController extends AbstractActionController
{
    protected $usersTable;

    public function indexAction()
    {
        $form = new RegistrationForm();
        $form->get('submit')->setValue('Регистрация');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $data = $this->prepareData($data);
                $auth = new Auth();
                $auth->exchangeArray($data);

                $this->getUsersTable()->saveUser($auth);

                $this->sendConfirmationEmail($auth);
                $this->flashMessenger()->addMessage($auth->usr_email);
                return $this->redirect()->toRoute('myauth', array('controller' => 'registration', 'action' => 'registration-success'));
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function registrationSuccessAction()
    {
        $usr_email = null;
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            foreach ($flashMessenger->getMessages() as $key => $value) {
                $usr_email .= $value;
            }
        }
        return new ViewModel(array('usr_email' => $usr_email));
    }

    public function confirmEmailAction()
    {
        $token = $this->params()->fromRoute('id');
        $viewModel = new ViewModel(array('token' => $token));
        try {
            $user = $this->getUsersTable()->getUserByToken($token);
            $usr_id = $user->usr_id;
            $this->getUsersTable()->activateUser($usr_id);
        } catch (\Exception $e) {
            $viewModel->setTemplate('myauth/registration/confirm-email-error.phtml');
        }
        return $viewModel;
    }


    public function passwordChangeSuccessAction()
    {
        $usr_email = null;
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            foreach ($flashMessenger->getMessages() as $key => $value) {
                $usr_email .= $value;
            }
        }
        return new ViewModel(array('usr_email' => $usr_email));
    }

    public function prepareData($data)
    {
        $data['usr_active'] = 0;
        $data['usr_password_salt'] = $this->generateDynamicSalt();
        $data['usr_password'] = $this->encriptPassword(
            $this->getStaticSalt(),
            $data['usr_password'],
            $data['usr_password_salt']

        );

        $data['usr_registration_token'] = md5(uniqid(mt_rand(), true));
        $data['usr_registration_token'] = uniqid(php_uname('n'), true);
        $data['usr_email_confirmed'] = 0;
        return $data;
    }

    public function generateDynamicSalt()
    {
        $dynamicSalt = '';
        for ($i = 0; $i < 50; $i++) {
            $dynamicSalt .= chr(rand(33, 126));
        }
        return $dynamicSalt;
    }

    public function getStaticSalt()
    {
        $staticSalt = '';
        $config = $this->getServiceLocator()->get('Config');
        $staticSalt = $config['static_salt'];
        return $staticSalt;
    }

    public function encriptPassword($staticSalt, $password, $dynamicSalt)
    {
        return $password = md5($staticSalt . $password . $dynamicSalt);
    }


    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('MyAuth\Model\UsersTable');
        }
        return $this->usersTable;
    }

    public function sendConfirmationEmail($auth)
    {
        $transport = $this->getServiceLocator()->get('mail.transport');
        $message = new Message();
        $this->getRequest()->getServer();
        $message->addTo($auth->usr_email)
            ->addFrom('praktiki@coolcsn.com')
            ->setSubject('Пожалуйста, подтвердите свою регистрацию!')
            ->setBody(iconv('utf-8', 'windows-1251',
                    "Пожалуйста, нажмите на ссылку для подтверждения регистрации => ") .
                $this->getRequest()->getServer('HTTP_ORIGIN') .
                $this->url()->fromRoute('myauth', array('controller' => 'registration', 'action' => 'confirm-email', 'id' => $auth->usr_registration_token)));
        $transport->send($message);
    }

}