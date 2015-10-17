<?php

namespace Anket\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Anket\Model\Anket;
use Anket\Model\AnketTable;
use Anket\Form\AnketForm;

use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

use Zend\Mail\Message;

class AnketController extends AbstractActionController
{
    protected $anketTable;

    CONST ROW_PAGE = 20;
    CONST RANGE_PAGE = 7;

    public function indexAction()
    {
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int)$this->params()->fromRoute('page') : 1;
        $type = $this->params()->fromRoute('type') ? (int)$this->params()->fromRoute('type') : 1;
        $anket = $this->getAnketTable()->fetchAll($select->order($order_by . ' ' . $order), $type);

        $anket->current();
        $paginator = new Paginator(new paginatorIterator($anket));
        $paginator->setCurrentPageNumber($page)
            ->setItemCountPerPage(self::ROW_PAGE)
            ->setPageRange(self::RANGE_PAGE);

        return new ViewModel(array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
            'type' => $type,
        ));
    }

    public function addAction()
    {
        $type = (int)$this->params()->fromRoute('type');
        $form = new AnketForm();
        $form->get('submit')->setValue('Отправить');
        $form->get('captcha')->setlabel('Введите код, указанный на картинке');
        $form->get('name_anket')->setValue($type);
        $form->get('comments')->setAttributes(
            array(
                'cols' => '60',
                'rows' => '5',
            ));

        $request = $this->getRequest();
        if ($request->isPost()) {
            $anket = new Anket();
            $form->setInputFilter($anket->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $anket->exchangeArray($form->getData());
                $this->getAnketTable()->saveAnket($anket);

                if ($data['send_mail']) {
                    $this->sendByEmail($anket);
                }

                return $this->redirect()->toRoute('anket', array('controller' => 'anket', 'action' => 'index', 'page' => '1', 'type' => $type));
            }
        }
        return array(
            'form' => $form,
            'type' => $type,
        );
    }

    public function userAction()
    {
        return new ViewModel(array(
            'anket' => $this->getAnketTable()->fetchAll(),
            'result' => $this->getAnketTable()->resultAnket(),
        ));
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('anket', array('controller' => 'anket', 'action' => 'user'));
        }

        try {
            $anket = $this->getAnketTable()->getAnket($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('anket', array('controller' => 'anket', 'action' => 'user'));
        }

        $form = new AnketForm();
        $form->get('comments')->setAttributes(
            array(
                'cols' => '60',
                'rows' => '5',
            ));
        $form->bind($anket);
        $form->get('submit')->setAttribute('value', 'Редактировать');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($anket->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAnketTable()->saveAnket($anket);

                return $this->redirect()->toRoute('anket', array('controller' => 'anket', 'action' => 'user'));
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $type = (int)$this->params()->fromRoute('type');
        foreach ($_POST as $checkbox => $value) {
            if ($checkbox != 'delete') {
                $this->getAnketTable()->deleteAnket($value);
            }
        }

        if ($type != null) $action = 'index';
        else $action = 'user';

        return $this->redirect()->toRoute('anket', array('controller' => 'anket', 'action' => $action, 'page' => '1', 'type' => $type));

    }


    public function getAnketTable()
    {
        if (!$this->anketTable) {
            $sm = $this->getServiceLocator();
            $this->anketTable = $sm->get('Anket\Model\AnketTable');
        }
        return $this->anketTable;
    }

    public function sendByEmail($anket)
    {
        $transport = $this->getServiceLocator()->get('mail.transport');
        $message = new Message();
        $this->getRequest()->getServer();
        $message->addTo($anket->email)
            ->addFrom('praktiki@coolcsn.com')
            ->setSubject('Дубликат вашой анкеты')
            ->setBody(iconv('utf-8', 'windows-1251',
                    "Ваша анкета  " . '<br />' .
                    'Ф.И.О: ' . $anket->name . '<br />' .
                    'Телефон: ' . $anket->phone . '<br />' .
                    'Вид оборудования: ' . $anket->type_equipment . '<br />' .
                    'Ваши коментарии: ' . $anket->comments)
            );
        $transport->send($message);
    }

}