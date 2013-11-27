<?php

namespace MCUCourseAPI\Helper;

class QueryHelper extends Helper
{

    const FILTER_SIMPLE = 'clear';
    const FILTER_BOTH = 'both';
    const FILTER_RIGHT = 'right';
    const FILTER_LEFT = 'left';

    protected $request = null;

    protected $builder = null;
    protected $model = null;
    protected $filterCount = 0;

    protected $perPage = 0;

    public function setModel($model)
    {
        $this->model = $model;
        $this->builder = $this->getDi()->getModelsManager()->createBuilder()->from($model);
    }

    public function usePage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function addFilter($name, $filterType = QueryHelper::FILTER_BOTH, $data = null)
    {

        $paramName = $name;

        if (is_array($name)) {
            $paramName = $name['param'];
            $name = $name['column'];
        }

        if (is_null($data)) {
            $data = $this->request->getQuery($paramName);
        }
        $query = "%:{$data}:%";

        $condition = "{$name} LIKE :{$name}:";

        if (is_null($data)) {
            return;
        }

        switch ($filterType) {
            case QueryHelper::FILTER_SIMPLE:
                $condition = "{$name} = :{$name}:";
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

        if ($this->filterCount > 0) {
            $this->builder->andWhere($condition, array($name => $query));
        } else {
            $this->builder->where($condition, array($name => $query));
        }

        $this->filterCount = $this->filterCount + 1;

    }

    # TODO: Very slow
    public function joinTables($accepts = array(), $tables = array(), $columns = array(), $groupBy = null)
    {
        $joinOn = array();
        $acceptTables = array();

        foreach ($accepts as $accept) {
            if (is_array($accept)) {
                array_push($acceptTables, $accept['table']);
                if (!empty($accept['joinOn'])) {
                    $joinOn[$accept['table']] = $accept['joinOn'];
                }
                continue;
            }
            array_push($acceptTables, $accept);
        }

        $joinTables = $this->request->getQuery('with');
        $joinTables = explode(',', $joinTables);
        $joinTables = array_merge($joinTables, $tables);
        if (count($acceptTables) > 0) {
            $joinTables = array_intersect($acceptTables, $joinTables);
        }

        foreach ($joinTables as $table) {
            if (empty($table)) {
                continue;
            }
            $tableName = $this->capitalize($table);
            $fullTableName = 'MCUCourseAPI\Models\\' . $tableName;
            $joinRule = null;
            if (!empty($joinOn[$table])) {
                $joinRule = $joinOn[$table];
            }
            $this->builder->innerJoin($fullTableName, $joinRule, $tableName);
        }

        if (!empty($groupBy)) {
            $this->builder->groupBy($groupBy);
        }

        if (count($columns) > 0) {
            $this->builder->columns($columns);
        }
    }

    public function result($toArray = true)
    {
        $result = $this->builder->getQuery()->execute();

        if ($this->perPage > 0) {
            $currentPage = $this->request->getQuery('page', 'int');
            $result = new \Phalcon\Paginator\Adapter\Model(array(
                "data" => $result,
                "limit" => $this->perPage,
                "page" => $currentPage
            ));
            $result = $result->getPaginate();
        } else {
            if ($toArray) {
                $result = $result->toArray();
                if (count($result) == 1) {
                    $result = $result[0];
                }
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
