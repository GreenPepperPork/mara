<?php

namespace mara\library\orm\sql;

/**
 * TODO 完善注释
 */
class Insert extends SQL
{
    /**
     * @var string
     */
    private $insertSql = 'INSERT INTO <TABLE> (<FIELD>) VALUES (<DATA>)';

    public function toString()
    {
        $sql = str_replace(
            ['<TABLE>', '<FIELD>', '<DATA>'],
            [
                $this->parseTable($this->options['table'] ?: null),
                $this->parseFields($this->options['fields'] ?: null),
                $this->parseValues($this->options['values'] ?: null)
            ],
            $this->insertSql
        );

        return $sql;
    }

    public function getParams()
    {
        return $this->options['values'];
    }
}
