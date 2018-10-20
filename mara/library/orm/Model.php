<?php

namespace mara\library\orm;

abstract class Model
{
    public $id;

    public function format($row)
    {
        foreach (get_object_vars($this) as $key => $value) {
            if (key_exists($key, $row)) {
                $this->$key = $row[$key];
            }
        }

        return $this;
    }
}