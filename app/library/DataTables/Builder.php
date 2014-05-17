<?php
namespace DataTables;

class Builder extends Base  {

    /**
     * @param \Phalcon\Mvc\Model\Query\BuilderInterface $builder
     * @return mixed
     */
    public function render($builder)
    {
        $from = $builder->getFrom();
        $this->cols = array_values($builder->getColumns());

        $this->render['recordsTotal'] = (int) $from::count([str_replace(['(', ')'],'',$builder->getWhere())]);

        $this->setFiltering();
        if($this->search['global'])
            foreach ($this->search['global'] as $globalSearch) {
            $builder->orWhere($globalSearch);
        }
        if($this->search['column'])
        foreach ($this->search['column'] as $columnSearch) {
            $builder->andWhere($columnSearch);
        }

        $this->render['recordsFiltered'] = (int) $from::count([str_replace(['(', ')'],'',$builder->getWhere()), 'bind' => $this->bound]);

        $this->setPaging();
        $builder->limit($this->paging);

        $this->setOrdering();
        if($this->ordering)
            $builder->orderBy(join(',', $this->ordering));

        $this->renderData($builder->getQuery()->execute($this->bound)->toArray());
        return $this->render;

    }
} 