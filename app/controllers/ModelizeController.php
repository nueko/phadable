<?php

class ModelizeController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $th = ['first_name', 'last_name', 'office', 'position', 'start_date', 'salary' => 'salary*10'];
        $this->view->setVar('th', $th);
        if ($this->request->isAjax() OR $this->request->get('draw')) {
            $this->view->disable();
            $datatables = new \DataTables\Model();
            $datatables->format('salary', function ($data) {
                return number_format($data, 0, ',', '.');
            });
            $datatables->format('start_date', function ($data) {
                return date('jS M y', strtotime($data));
            });
            $manager = $datatables->simple('Employees', [
                'columns' => $th
            ]);
            $this->response->setJsonContent($manager)->setContentType('application/json')->send();
        }
    }

}

