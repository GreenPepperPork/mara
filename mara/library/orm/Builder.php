<?php

namespace mara\library\orm;

use Exception;
use mara\library\Config;
use mara\library\orm\sql\SQL;

class Builder
{
    const DNS_MASTER = 'master';

    const DNS_SLAVE = 'slave';

    /**
     * @var \PDO
     */
    protected $handler;

    protected $config;

    public function __construct(array $config = [])
    {
        if (isset($config['options'])) {
            $config['options'][\PDO::MYSQL_ATTR_FOUND_ROWS] = true;
        } else {
            $config['options'] = [\PDO::MYSQL_ATTR_FOUND_ROWS => true];
        }

        if (!isset($config['master']) || !isset($config['slave'])) {
            throw new \InvalidArgumentException('Invalid database config, require "master" and "slave" key.');
        }

        $this->config = $config;
    }

    /**
     * @param string $dsn
     * @return \PDO
     * @throws Exception
     */
    public function connect($dsn = Builder::DNS_MASTER)
    {
        if ($this->isConnected($dsn)) {
            return $this->handler[$dsn];
        }

        // TODO 增加config的判断
        $config = Config::get($this->config[$dsn], 'database');

        $dsn      = $config['dsn'];
        $username = $config['username'] ?: null;
        $password = $config['password'] ?: null;
        $options  = $config['options'] ?: [];

        $options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;

        try {
            $handler = new \PDO($dsn, $username, $password, $options);
        } catch (Exception $exception) {
            throw new Exception('Database connect failed!', 0, $exception);
        }

        return $this->handler = $handler;
    }

    public function disconnect()
    {
        unset($this->handler);

        return $this;
    }

    /**
     * @param $dsn
     * @return bool
     */
    public function isConnected($dsn)
    {
        return $this->handler[$dsn] instanceof \PDO;
    }

    /**
     * @param $sql
     * @param null $params
     * @return Statement
     * @throws Exception
     */
    public function state($sql, $params = null)
    {
        $params = $params === null
            ? []
            : is_array($params) ? $params : array_slice(func_get_args(), 1);

        if ($sql instanceof \PDOStatement || $sql instanceof Statement) {
            $stat = $sql;
            $stat->execute($params);
        } elseif ($params) {
            $stat = $this->connect()->prepare($sql);
            $stat->execute($params);
        } else {
            $stat = $this->connect()->query($sql);
        }

        $stat->setFetchMode(\PDO::FETCH_ASSOC);

        return Statement::factory($stat);
    }

    public function prepare()
    {
        $handler = $this->connect();
        $statement = call_user_func_array([$handler, 'prepare'], func_get_args());

        return Statement::factory($statement);
    }

    public function getLastInsertId()
    {
        return $this->handler->lastInsertId();
    }

    /**
     * 根据当前查询对象的各项参数，编译为具体的select语句及查询参数.
     *
     * @param SQL $sqlType
     * @param array $options
     * @return array (
     * array(
     * (string),    // select语句
     * (array)      // 查询参数值
     * )
     */
    public function compile($sqlType, array $options)
    {
        /** @var SQL $sqlBuilder */
        $sqlBuilder = new $sqlType($options);

        return $sqlBuilder->toSql();
    }

    public function quote($value)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->quote($v);
            }

            return $value;
        }

        if ($value === null) {
            return 'NULL';
        }

        return $this->connect()->quote($value);
    }

    public function __sleep()
    {
        $this->disconnect();
    }

    public function __call($method, array $args)
    {
        return $args ? call_user_func_array([$this->connect(), $method], $args) : $this->connect()->$method();
    }
}