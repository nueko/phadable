<?php
namespace DataTables;

use Phalcon\Mvc\Model\Resultset;

class Model extends Base
{

    /**
     * @param $model \Phalcon\Mvc\Model
     * @param array $parameters
     * @return array
     */
    public function simple($model, $parameters = [])
    {
        $this->cols = $parameters['columns'];
        $this->render['recordsTotal'] = $model::count($parameters);
        $this->setFiltering();

        if ($this->search['global']) {
            $parameters['conditions'] = empty($parameters['conditions']) ? NULL : $parameters['conditions'] .' AND ';
            $parameters['conditions'] .= implode(' OR ', $this->search['global']);
        }
        if ($this->search['column']) {
            $parameters['conditions'] = empty($parameters['conditions']) ? NULL : $parameters['conditions'] .' AND ';
            $parameters['conditions'] .= implode(' AND ', $this->search['column']);
        }

        $parameters['bind'] = empty($parameters['bind']) ? $this->bound : array_merge($parameters['bind'],$this->bound);

        $this->render['recordsFiltered'] = $model::count($parameters);

        $this->setOrdering();
        $gen['order'] = join(',', $this->ordering);

        $this->setPaging();
        $gen['limit'] = $this->paging;
        $gen['hydration'] = Resultset::HYDRATE_ARRAYS;


        $this->renderData($model::find(array_merge_recursive($parameters, $gen)));

        return ($this->render);

    }

    public function render($builder)
    {
        $from       = $builder->getFrom();
        $this->cols = $builder->getColumns();

        $this->render['recordsTotal'] = (int)$from::count(['condition' => $builder->getWhere()]);

        $this->setFiltering();

        if ($this->search['global'])
            foreach ($this->search['global'] as $globalSearch) {
                $builder->orWhere($globalSearch);
            }
        if ($this->search['column'])
            foreach ($this->search['column'] as $columnSearch) {
                $builder->andWhere($columnSearch);
            }

        $this->render['recordsFiltered'] = (int)$from::count([str_replace(['(', ')'], '', $builder->getWhere()), 'bind' => $this->bound]);

        $this->setPaging();
        $builder->limit($this->paging);

        $this->render['where'] = str_replace(['(', ')'], '', $builder->getWhere());

        $this->setOrdering();
        if ($this->ordering)
            $builder->orderBy(join(',', $this->ordering));
        $v = [];
        foreach ($builder->getQuery()->execute($this->bound)->toArray() as $ar) {
            $v[] = array_values($ar);
        }

        $this->render['data'] = $v;

        return $this->render;

    }
} 