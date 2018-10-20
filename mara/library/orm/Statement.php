<?php

namespace mara\library\orm;

class Statement
{
    protected $statement;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @param $statement
     * @return static
     */
    public static function factory($statement)
    {
        if ($statement instanceof self) {
            return $statement;
        }

        if ($statement instanceof \PDOStatement) {
            return new static($statement);
        }

        throw new \InvalidArgumentException('Invalid statement');
    }

    /**
     * 返回用于执行的sql语句.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->statement->queryString;
    }

    /**
     * 从查询结果提取下一行.
     *
     * @return array
     */
    public function getRow()
    {
        return $this->statement->fetch();
    }

    /**
     * 从下一行行中获取指定列的数据.
     *
     * @param int $col_number 列序号
     *
     * @return mixed
     */
    public function getCol($col_number = 0)
    {
        return $this->statement->fetch(\PDO::FETCH_COLUMN, $col_number);
    }

    /**
     * 获取查询结果内指定列的所有结果.
     *
     * @param int $col_number 列序号
     *
     * @return array
     */
    public function getCols($col_number = 0)
    {
        return $this->statement->fetchAll(\PDO::FETCH_COLUMN, $col_number);
    }

    /**
     * 获取行数量
     *
     * @return mixed
     */
    public function getCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * 返回所有的查询结果，允许以指定的字段内容为返回数组的key.
     *
     * @param null $column
     * @return array
     * @internal param string $col
     *
     */
    public function getAll($column = null)
    {
        if (!$column) {
            return $this->statement->fetchAll();
        }

        $rowSet = [];
        while ($row = $this->statement->fetch()) {
            $rowSet[$row[$column]] = $row;
        }

        return $rowSet;
    }

    /**
     * 返回上一个SQL影响的行数
     *
     * @return int
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }
}
