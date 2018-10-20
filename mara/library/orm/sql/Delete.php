<?php

namespace mara\library\orm\sql;

/**
 * TODO 完善注释
 */
class Delete extends SQL
{
    /**
     * @var string
     */
    private $deleteSql = 'DELETE FROM <TABLE> <WHERE><LIMIT>';

    /**
     * // TODO 用预查询来查询
     *
     * @return mixed
     */
    public function toString()
    {
        $sql = str_replace(
            ['<TABLE>', '<WHERE>', '<LIMIT>'],
            [
                $this->parseTable($this->options['table'] ?: null),
                $this->parseWhere($this->options['where'] ?: null),
                $this->parseLimit($this->options['limit'] ?: null, $this->options['offset'] ?: null)
            ],
            $this->deleteSql
        );

        return $sql;
    }

    public function getParams()
    {
        return $this->params;
    }
}
