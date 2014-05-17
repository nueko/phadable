<?php
namespace DataTables;


use Phalcon\Db\Adapter\Pdo as Adapter;
use Phalcon\Db;
use Phalcon\Exception;

class Pdo extends Base
{


    /**
     * @var \Phalcon\Db\Adapter\Pdo\Mysql
     */
    private $db;

    private $defaultQuery;
    private $buildQuery;
    private $searchQuery;
    private $orderBy;
    private $limit;
    private static $glue = ' WHERE ';

    /**
     * @param $di \Phalcon\DiInterface
     */
    public function __construct($di)
    {
        $this->db      = $di->get('db');
        $this->request = $di->get('request');
    }

    public function query($sql)
    {
        $this->setBindFormat(':bind');
        $this->defaultQuery = $sql;
        $this->_setColumns($sql);
        $this->render['recordsTotal'] = $this->db->query($sql)->numRows();
        $this->setFiltering();
        if ($this->search['global'])
            $this->searchQuery .= implode(' OR ', $this->search['global']);
        if ($this->search['column'])
            $this->searchQuery .= implode(' AND ', $this->search['column']);
        $this->setOrdering();
        $this->orderBy = " ORDER BY " . implode(',', $this->ordering);
        $this->setPaging();
        $this->limit = " LIMIT " . $this->paging['offset'] . ',' . $this->paging['number'];

        return $this;
    }

    public function make()
    {
        if ($this->searchQuery) {
            try {
                $query = $this->db->query(
                    $this->defaultQuery . self::$glue . $this->searchQuery,
                    $this->bound
                );
            } catch (\PDOException $e) {
                self::$glue = ' AND ';
                $query      = $this->db->query(
                    $this->defaultQuery . self::$glue . $this->searchQuery,
                    $this->bound
                );
            }
            $this->render['recordsFiltered'] = $query->numRows();
        } else {
            self::$glue                      = '';
            $this->render['recordsFiltered'] = $this->render['recordsTotal'];
        }
        $sql = $this->defaultQuery . self::$glue . $this->searchQuery . $this->orderBy . $this->limit;
        $this->renderData($this->db->fetchAll($sql, Db::FETCH_NUM, $this->bound));

        return $this->render;
    }

    public function _setColumns($sql)
    {
        preg_match('/SELECT (.*?) FROM/i', $sql, $matches);
        if (! $matches)
            throw new Exception ('No Column can be parsed');
        $patern = '/(.*)\s+as\s+(\w*)/i';
        foreach($this->explode(',', $matches[1]) as $val)
        {
            $val = trim($val);
            $column = trim(preg_replace($patern, '$2', $val));
            if($val == $column){
                $this->cols[] = $val;
            } else {
                $this->cols[$column] =  trim(preg_replace($patern, '$1', $val));
            }
        }
        return $this;
    }

    /**
     * Explode, but ignore delimiter until closing characters are found
     * extracted from ignited datatables (shame on me)
     *
     * @param string $delimiter
     * @param string $str
     * @param string $open
     * @param string $close
     * @return mixed $retval
     */
    private function explode($delimiter, $str, $open = '(', $close = ')')
    {
        $retval  = array();
        $hold    = array();
        $balance = 0;
        $parts   = explode($delimiter, $str);

        foreach ($parts as $part) {
            $hold[] = $part;
            $balance += $this->balanceChars($part, $open, $close);

            if ($balance < 1) {
                $retval[] = implode($delimiter, $hold);
                $hold     = array();
                $balance  = 0;
            }
        }

        if (count($hold) > 0)
            $retval[] = implode($delimiter, $hold);

        return $retval;
    }

    /**
     * Return the difference of open and close characters
     * extracted from ignited datatables (shame on me)
     *
     * @param string $str
     * @param string $open
     * @param string $close
     * @return int $retval
     */
    private function balanceChars($str, $open, $close)
    {
        $openCount  = substr_count($str, $open);
        $closeCount = substr_count($str, $close);
        $retval     = $openCount - $closeCount;

        return $retval;
    }

}