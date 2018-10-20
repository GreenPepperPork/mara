<?php

namespace mara\library\orm\sql;

/**
 * @method static bool isInsert($sqlType)
 * @method static bool isDelete($sqlType)
 * @method static bool isUpdate($sqlType)
 * @method static bool isSelect($sqlType)
 */
abstract class SQL
{
    protected $options;

    protected $params = [];

    protected $identifierSymbol = '`';

    function __construct($options)
    {
        $this->options = $options;
    }

    function __toString()
    {
        return $this->toString();
    }

    /**
     * 判断当前SQL的种类
     *
     * @param string $sqlFunc
     * @param array  $arguments
     * @return bool
     */
    public static function __callStatic($sqlFunc, $arguments)
    {
        $sqlFunc = strtr($sqlFunc, ['is' => '']);
        list($sqlType) = $arguments;

        if (is_string($sqlType)) {
            return '\\zaor\\orm\\sql\\' . $sqlFunc == BS . ltrim($sqlType, BS);
        } else if ($sqlType instanceof self) {
            return is_subclass_of($sqlType, '\\zaor\\orm\\sql\\' . $sqlFunc);
        }

        return false;
    }

    abstract function toString();

    public function toSql()
    {
        return [$this->toString(), $this->getParams()];
    }

    public function getParams()
    {
        return $this->params;
    }

    protected function parseTable($compileTable)
    {
        $table = $this->quoteIdentifier($compileTable);

        return $table;
    }

    protected function parseFields($compileFields)
    {
        if (!$compileFields) {
            return '';
        }

        $fields = [];
        foreach ($compileFields as $field) {
            $fields[] = $this->quoteIdentifier($field);
        }

        return implode(',', $fields);
    }

    protected function parseValues($compileValues)
    {
        if (!$compileValues) {
            return '';
        }

        return implode(',', array_fill(0, count($compileValues), '?'));
    }

    protected function parseWhere($compileWhere = null)
    {
        if (!$compileWhere) {
            return '';
        }

        $where = [];
        foreach ($compileWhere as $field => $value) {
            if (is_array($value)) {
                $where[] = "{$field} in (" . implode(',', array_fill(0, count($value), '?')) . ")";
                $this->params = array_merge($this->params, $value);
            } else {
                $where[] = "{$field} = ?";
                $this->params[] = $value;
            }
        }

        $where = 'WHERE (' . implode(') AND (', $where) . ')';

        return $where;
    }

    protected function parseUpdate($compileWhere = null)
    {
        if (!$compileWhere) {
            return '';
        }

        $where = [];
        foreach ($compileWhere as $field => $value) {
            $where[] = "{$field} = ?";
            $this->params[] = $value;
        }

        $where = implode(',', $where);

        return $where;
    }

    protected function parseOrder($compileOrder = null)
    {
        if (is_null($compileOrder)) {
            return '';
        }

        $order = [];
        foreach ($compileOrder as $column => $sort) {
            $order[] = $this->quoteIdentifier($column) . ' ' . $sort;
        }

        return ' ORDER BY ' . implode(', ', $order);
    }

    protected function parseLimit($compileLimit = null, $compileOffset = null)
    {
        if (!is_numeric($compileLimit)) {
            return '';
        }

        $limit = '';

        $limit .= ' LIMIT ' . $compileLimit;
        $limit .= ' OFFSET ' . $compileOffset ?: 0;

        return $limit;
    }

    private function quoteIdentifier($identifier)
    {
        if (is_array($identifier)) {
            return array_map([$this, 'quoteIdentifier'], $identifier);
        }

        $symbol = $this->identifierSymbol;
        $identifier = str_replace(['"', "'", ';', $symbol], '', $identifier);

        $result = [];
        foreach (explode('.', $identifier) as $s) {
            $result[] = $symbol . $s . $symbol;
        }

        return implode('.', $result);
    }
}