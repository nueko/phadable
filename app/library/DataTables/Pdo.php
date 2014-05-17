<?php
namespace DataTables;


use Phalcon\Db\Adapter\Pdo as Adapter;

class Pdo extends Base {


    /**
     * @var \Phalcon\Db\Adapter\Pdo\Mysql
     */
    private $db;

    public function __construct($db)
    {
        $this->db = new Adapter\Mysql($db);
        parent::__construct();
    }

    public function render($query)
    {
        $this->setFiltering();
        return $this->search;
    }

} 