<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace storage\model\cache;

use mara\library\cache\driver\Redis;
use mara\library\Config;
use storage\dto\OptionDTO;

class OptionModel extends Redis
{
    public $prefixKey = 'OptionModel';

    public function __construct()
    {
        parent::__construct(Config::get('MaraRedis', 'redis'));
    }

    public function setOption($number, OptionDTO $option, $isReset = false)
    {
        if (empty($number)) {
            return false;
        }

        $key = $this->buildKey($number);

        if ($isReset) {
            $this->reset($key);
        }

        return $this->handler()->hSet($key, $option->order, serialize($option));
    }

    public function getAllOption($number)
    {
        $key = $this->buildKey($number);

        $result = $this->handler()->hGetAll($key);

        return $result;
    }

    /**
     * 重置哈希值
     *
     * @param string $key
     * @return bool|int
     */
    public function reset($key)
    {
        if (empty($key)) {
            return false;
        }

        return $this->handler()->del($key);
    }

    public function buildKey($number)
    {
        return $this->prefixKey . '_' . $number;
    }
}