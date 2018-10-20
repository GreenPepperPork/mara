<?php

namespace mara\library\orm\symbol;

use Exception;
use mara\library\Config;
use mara\library\orm\sql\SQL;

class Like
{
    private $like;

    function __construct($like)
    {
        $this->like = $like;
    }

    public function getValue()
    {
        return $this->like;
    }
}