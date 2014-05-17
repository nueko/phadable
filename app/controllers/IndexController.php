<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $datatables = new \DataTables\Builder();
        $cols = ['first_name', 'last_name', 'office','pos'=> 'position','mulai'=> 'start_date', 'gaji' => 'salary/2'];
        $manager = $this->modelsManager->createBuilder()->columns($cols)->from('Employees');
        $this->view->setVar('th', $manager->getColumns());
        $datatables->format('gaji', function($data){
            return number_format($data, 0, ',', '.');
        });
        $datatables->format('mulai', function($data){
            return date( 'jS M y', strtotime($data));
        });
        if($this->request->isAjax() OR $this->request->get('draw')){
            $this->view->disable();
            $this->response->setJsonContent(
                $datatables->render($manager)
            )->setContentType('application/json')->send();
        }
    }



}

