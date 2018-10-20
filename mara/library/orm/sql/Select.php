<?php

namespace mara\library\orm\sql;

/**
 * TODO 完善注释
 */
class Select extends SQL
{
    /**
     * @var string
     */
    private $selectSql = 'SELECT * FROM <TABLE> <WHERE><ORDER><LIMIT><OFFSET>';

    public function toString()
    {
        $sql = str_replace(
            ['<TABLE>', '<WHERE>', '<ORDER>', '<LIMIT>', '<OFFSET>'],
            [
                $this->parseTable(isset($this->options['table']) ? $this->options['table'] : null),
                $this->parseWhere(isset($this->options['where']) ? $this->options['where'] : null),
                $this->parseOrder(isset($this->options['order']) ? $this->options['order'] : null),
                $this->parseLimit(isset($this->options['limit']) ? $this->options['limit'] : null, isset($this->options['offset']) ? $this->options['offset'] : null)
            ],
            $this->selectSql
        );

        return $sql;
    }

    public function getParams()
    {
        return $this->params;
    }
}
