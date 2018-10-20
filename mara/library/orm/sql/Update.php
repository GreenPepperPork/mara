<?php

namespace mara\library\orm\sql;

/**
 * TODO 完善注释
 */
class Update extends SQL
{
    /**
     * @var string
     */
    private $updateSql = 'UPDATE <TABLE> SET <SET> <WHERE>';

    public function toString()
    {
        $sql = str_replace(
            ['<TABLE>', '<SET>', '<WHERE>'],
            [
                $this->parseTable($this->options['table'] ?: null),
                $this->parseValues(array_keys($this->options['update']) ?: null),
                $this->parseWhere(($this->options['where'] ?: null))
            ],
            $this->updateSql
        );

        return $sql;
    }
}
