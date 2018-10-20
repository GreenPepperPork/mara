<?php

namespace mara\library\orm;

abstract class Dao
{
    /**
     * @var string|null 主节点
     */
    public $master;

    /**
     * @var string|null 从节点
     */
    public $slave;

    /**
     * @var string 表名
     */
    public $table = '';

    /**
     * @var string 表前缀
     */
    public $prefix = '';

    /**
     * @var bool 是否跳过缓存
     */
    protected $skipCache = false;

    /**
     * @var string|object
     */
    protected $model = null;

    /**
     * @var array options
     */
    protected $options = [];

    /**
     * @var Builder
     */
    protected static $builder = [];

    /**
     * 初始化Dao
     */
    abstract function init();

    function __construct()
    {
        $this->init();
    }

    public function getInfo()
    {
        $model = $this->model;
        if (!is_object($this->model) && class_exists($this->model)) {
            $model = new $model;
        }
        $model = is_object($model) ? $model : null;

        // TODO 获取daoInfo这个需要调整,现在是手动赋值
        return [
            'master' => $this->master,
            'slave'  => $this->slave,
            'model'  => $model,
            'table'  => $this->getTableName(),

            'skipCache' => is_null($this->skipCache) ? false : $this->skipCache
        ];
    }

    /**
     * @return Query
     * @throws \Exception
     */
    public function query()
    {
        $builder = null;

        if (empty(self::$builder[$this->master][$this->slave])) {
            self::$builder[$this->master][$this->slave] = new Builder([
                'master' => $this->master,
                'slave'  => $this->slave
            ]);
        }

        $builder = self::$builder[$this->master][$this->slave];
        if (!$builder instanceof Builder) {
            throw new \Exception('Builder Cant not find master or slave options');
        }

        // TODO 这里参数可能还是需要调整一下
        return new Query(self::$builder[$this->master][$this->slave], $this->getInfo());
    }

    public function getTableName()
    {
        return $this->prefix ? $this->prefix . $this->table : $this->table;
    }
}