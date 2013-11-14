<?php

class QueryHelper extends Helper
{

  const FILTER_SIMPLE = 'clear';
  const FILTER_BOTH = 'both';
  const FILTER_RIGHT = 'right';
  const FILTER_LEFT = 'left';

  protected $request = null;

  protected $model = null;
  protected $filterCount = 0;

  protected $perPage = 0;

  public function setModel($model)
  {
    $this->model = $model;
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
      $this->model->andWhere($condition, array($name => $query));
    } else {
      $this->model->where($condition, array($name => $query));
    }

    $this->filterCount = $this->filterCount + 1;

  }

  public function result()
  {
    $result = $this->model->execute();

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

}
