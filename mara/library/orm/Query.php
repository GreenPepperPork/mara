<?php

namespace mara\library\orm;

use app\mara\dao\MemberDao;
use app\mara\model\MemberModel;
use mara\library\orm\sql\Delete;
use mara\library\orm\sql\Insert;
use mara\library\orm\sql\Select;
use mara\library\orm\sql\SQL;
use mara\library\orm\sql\Update;

class Query
{
    /**
     * @var array 查询参数
     */
    protected $bindParams = [];

    /**
     * @var array 数据库相关信息
     */
    protected $daoInfo = [];

    /**
     * 数据库驱动.
     *
     * @var Builder
     */
    private $builder;

    /**
     * @var \Generator
     */
    protected $strategyGenerator;

    /**
     * @param Builder $builder
     * @param array $daoInfo
     */
    public function __construct(Builder $builder, array $daoInfo)
    {
        $this->builder = $builder;
        $this->daoInfo = $daoInfo;
        $this->setTable($daoInfo['table']);
    }

    public function __destruct()
    {
        $this->builder = null;
    }

    /**
     * 返回select语句.
     *
     * @return string
     */
    public function __toString()
    {
        list($sql) = $this->compile();

        return $sql;
    }

    /**
     * 获取数据库驱动.
     *
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * 获取实例化model
     *
     * @return null|Model
     */
    public function getModel()
    {
        $model = $this->daoInfo['model'] ?: null;

        if (is_string($model)) {
            if (!class_exists($model)) {
                return null;
            }

            $model = new $model;
        }

        if (!is_object($model) || !$model instanceof Model) {
            return null;
        }

        return $model;
    }

    /**
     * 获取表名称
     *
     * @return string
     */
    public function getTable()
    {
        return $this->bindParams['table'];
    }

    public function setTable($table)
    {
        $this->bindParams['table'] = $table;
    }

    /**
     * 设置查询条件,只支持and
     *
     * @param array $where
     *
     * @return $this
     *
     * @example
     * $select->where(['foo' => 1]);
     */
    public function where(array $where)
    {
        if (empty($this->bindParams['where'])) {
            $this->bindParams['where'] = [];
        }
        $this->bindParams['where'] += $where;

        return $this;
    }

    /**
     * order by 语句.
     *
     * @param array
     *
     * @return $this
     */
    public function orderBy(array $orders)
    {
        foreach ($orders as $key => $order) {
            if (is_numeric($key)) {
                $column = $order;
                $sort = 'ASC';
            } else {
                $column = $key;
                $sort = $order;
            }

            $sort = (strtoupper($sort) === 'DESC') ? 'DESC' : 'ASC';

            $this->bindParams['order'][$column] = $sort;
        }

        return $this;
    }

    /**
     * limit语句.
     *
     * @param int $limit
     *
     * @param int $offset
     * @return $this
     */
    public function limit($limit, $offset = 0)
    {
        if ($limit) {
            $this->bindParams['limit'] = abs((int) $limit);
        }

        if (is_numeric($offset)) {
            $this->bindParams['offset'] = abs((int) $offset);
        }

        return $this;
    }

    /**
     * 查询当前查询条件在表内的行数.
     *
     * @return int
     * @throws \Exception
     */
    public function count()
    {
        $count = $this->execute(Select::class)->getCount();

        return $count;
    }

    /**
     * 获得所有的查询结果.
     *
     * @param null $limit
     * @param int $offset
     *
     * @return array
     * @throws \Exception
     *
     */
    public function get($limit = null, $offset = 0)
    {
        if ($limit !== null) {
            $this->limit($limit, $offset);
        }

        $exeResult = $this->execute(Select::class);
        if (!$exeResult instanceof Statement) {
            return $exeResult;
        }

        $records = [];
        while ($record = $exeResult->getRow()) {
            $records[] = $this->getModel()->format($record);
        }

        return $records;
    }

    /**
     * 只查询返回第一行数据.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getOne()
    {
        $records = $this->get(1);

        return array_shift($records);
    }

    /**
     * 插入数据
     *
     * @param array $row
     * @return int|boolean $lastInsertId 最后插入的主键ID
     * @throws \Exception
     */
    public function insert(array $row)
    {
        if (empty($row)) {
            return false;
        }

        $this->bindParams['fields'] = array_keys($row);
        $this->bindParams['values'] = array_values($row);

        $this->execute(Insert::class);

        return $this->builder->getLastInsertId();
    }

    /**
     *
     * 根据当前的条件，删除相应的数据.
     *
     * @param null $limit
     * @param int $offset
     * @return int affected row count
     * @throws \Exception
     */
    public function delete($limit = null, $offset = 0)
    {
        if ($limit !== null) {
            $this->limit($limit, $offset);
        }

        return $this->execute(Delete::class)->rowCount();
    }

    /**
     * 根据当前查询语句的条件参数更新数据.
     *
     * @param array $row
     * @return int affected row count
     * @throws \Exception
     */
    public function update(array $row)
    {
        if (empty($row)) {
            return false;
        }

        $this->bindParams['update'] = $row;

        return $this->execute(Update::class)->rowCount();
    }

    /**
     * 编译当前的SQL语句
     *
     * @param SQL $sqlType
     * @return array
     */
    private function compile($sqlType = null)
    {
        return $this->builder->compile($sqlType, $this->bindParams);
    }

    /**
     * 执行查询，返回查询结果句柄对象
     *
     * @param SQL $sqlType
     * @return Statement|array
     * @throws \Exception
     */
    private function execute($sqlType = null)
    {
        if (!is_subclass_of($sqlType, SQL::class)) {
            throw new \Exception('Bad SQL type');
        }

        list($sql, $params) = $this->compile($sqlType);

        return $this->builder->state($sql, $params);
    }
}