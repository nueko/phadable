<?php namespace DataTables;


use Phalcon\Http\Request;

abstract class Base
{
    /**
     * @var \Phalcon\Http\Request
     */
    protected $request;
    protected $searchFormat = '%search%';
    protected $bindFormat = ':bind:';
    protected $paging = ['offset' => 0, 'number' => 0];
    protected $ordering = [];
    protected $bound = [];
    protected $criteria = [];
    protected $search = ['global' => [], 'column' => []];
    public  $cols = [];
    private $format = [];
    protected $render = [
        "draw"            => 0,
        "recordsTotal"    => 0,
        "recordsFiltered" => 0,
        "data"            => [],
    ];

    public function __construct()
    {
        $this->request = new Request();
    }

    public function format($columnIndex, $format = NULL)
    {
        if(is_array($columnIndex)){
            foreach ($columnIndex as $col => $func) {
                $this->format[$col] = $func;
            }

        } else {
            $this->format[$columnIndex] = $format;
        }

        return $this;
    }

    protected function renderData($data)
    {
        foreach ($data as $ar) {
            if ($this->format)
                foreach ($this->format as $c => $v) {
                    $ar[$c] = $this->format[$c]($ar[$c]);
                }
            $this->render['data'][] = array_values($ar);
        }
    }

    protected function setPaging()
    {
        if ($this->request->hasQuery('start') AND $this->request->get('length') != - 1) {
            $this->paging = [
                'offset' => $this->request->get('start'),
                'number' => $this->request->get('length')
            ];
        }

        return $this;
    }

    protected function setOrdering()
    {
        if ($this->request->has('order')) {
            $order   = $this->request->get('order');
            $columns = $this->request->get('columns');

            foreach ($order as $i => $o) {
                $colId      = intval($order[$i]['column']);
                $requestCol = $columns[$colId];
                $colKey     = array_search($requestCol['data'], array_keys($this->cols));
                if ($columns[$i]['orderable'] == 'true') {
                    $orderDir         = (strtolower($order[$i]['dir']) == 'asc') ? 'ASC' : 'DESC';
                    $this->ordering[] = join(' ', [$this->cols[$colKey], $orderDir]);
                }
            }
        }

        return $this;
    }

    protected function setFiltering()
    {
        $search    = $this->request->get('search');
        $columns   = $this->request->get('columns');
        $colsTable = range(0, count($this->cols));
        //global generate or like
        if (is_array($search) AND $search['value'] != '') {
            for ($i = 0, $ien = count($columns); $i < $ien; $i ++) {
                $colKey = array_search($columns[$i]['data'], array_keys($this->cols));

                if ($columns[$i]['searchable'] == 'true') {
                    $this->bound              = ["search" => $this->searchFormat($search['value'])];
                    $this->search['global'][] = $this->cols[$colKey] . ' LIKE ' . $this->bindFormat("search");
                }
            }
        }

        //individual generate and like
        for ($i = 0, $ien = count($columns); $i < $ien; $i ++) {
            $colKey = array_search($columns[$i]['data'], array_keys($this->cols));

            $str = $columns[$i]['search']['value'];
            if ($columns[$i]['searchable'] == 'true' && $str != '') {
                $this->bound              = ["search_$i" => $this->searchFormat($str)];
                $this->search['column'][] = $this->cols[$colKey] . ' LIKE ' . $this->bindFormat("search_$i");
            }
        }

        return $this;
    }

    private function searchFormat($value = '')
    {
        if (! $value)
            return $this->searchFormat;

        return str_replace('search', $value, $this->searchFormat);
    }

    public function setSearchFormat($format = '%search%')
    {
        $this->searchFormat = $format;
        return $this;
    }

    private function bindFormat($value)
    {
        return str_replace('bind', $value, $this->bindFormat);
    }

    public function setBindFormat($format = ':bind:')
    {
        $this->bindFormat = $format;
        return $this;
    }

    public function detect()
    {
        return ($this->request->has('draw') && $this->request->isAjax());
    }

    public function getColumns()
    {
        $columns = [];
        foreach ($this->cols as $i => $col) {
            if(is_numeric($i))
                $columns[] = $col;
            else
                $columns[] = $i;
        }
        return $columns;
    }

    public function getRealColumns()
    {
        return $this->cols;
    }

} 