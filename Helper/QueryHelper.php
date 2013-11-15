<?php

class QueryHelper extends Helper
{

  const FILTER_SIMPLE = 'clear';
  const FILTER_BOTH = 'both';
  const FILTER_RIGHT = 'right';
  const FILTER_LEFT = 'left';

  protected $request = null;

  protected $builder = null;
  protected $filterCount = 0;

  protected $perPage = 0;

  public function setModel($model)
  {
    $this->builder = $this->getDi()->getModelsManager()->createBuilder()->from($model);
  }

  public function usePage($perPage)
  {
    $this->perPage = $perPage;
  }

  public function addFilter($name, $filterType = QueryHelper::FILTER_BOTH, $data = null)
  {

    $paramName = $name;

    if(is_array($name)) {
      $paramName = $name['param'];
      $name = $name['column'];
    }

    if(is_null($data)) {
      $data = $this->request->getQuery($paramName);
    }
    $query = "%:{$data}:%";

    switch($filterType) {
      case QueryHelper::FILTER_SIMPLE:
       $query = "{$data}";
        break;
      case QueryHelper::FILTER_BOTH:
        $query = "%{$data}%";
        break;
      case QueryHelper::FILTER_RIGHT:
        $query = "{$data}%";
        break;
      case QueryHelper::FILTER_LEFT:
        $query = "%{$data}";
        break;
    }

    $condition = "{$name} LIKE :{$name}:";

    if($this->filterCount > 0) {
      $this->builder->andWhere($condition, array($name => $query));
    } else {
      $this->builder->where($condition, array($name => $query));
    }

    $this->filterCount = $this->filterCount + 1;

  }

  public function joinTables($accepts = array())
  {
    $joinTables = $this->request->getQuery('with');
    $joinTables = explode(',', $joinTables);

    foreach($joinTables as $table) {
      if(empty($table)) continue;
      $tableName = $this->capitalize($table);
      $this->builder->join($tableName);
      $this->builder->groupBy("Courses.id");
    }
  }

  public function result()
  {
    $result = $this->builder->getQuery()->execute();

    if($this->perPage > 0) {
      $currentPage = $this->request->getQuery('page', 'int');
      $result = new \Phalcon\Paginator\Adapter\Model(array(
        "data" => $result,
        "limit" => $this->perPage,
        "page" => $currentPage
      ));
      $result = $result->getPaginate();
    } else {
      $result = $result->toArray();
      if(count($result) == 1) {
        $result = $result[0];
      }
    }

    return $result;
  }

  public function setDi($di)
  {
    parent::setDi($di);

    $this->request = $this->getDi()->getRequest();
  }

  private function capitalize($name)
  {
    $name = str_replace('_', ' ', $name);
    $name = ucwords($name);
    $name = str_replace(' ', '', $name);
    return $name;
  }

}
