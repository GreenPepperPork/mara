<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace storage\model\cache;

use storage\dto\QuestionDTO;
use mara\library\cache\driver\Redis;
use mara\library\Config;

class QuestionModel extends Redis
{
    public $prefixKey = 'QuestionModel';

    public function __construct()
    {
        parent::__construct(Config::get('MaraRedis', 'redis'));
    }

    public function setQuestion($number, QuestionDTO $question, $isReset = false)
    {
        if (empty($number)) {
            return false;
        }

        $key = $this->buildKey($number);

        if ($isReset) {
            $this->reset($key);
        }

        return $this->handler()->hMset($key, (array) $question);
    }

    public function getQuestion($number)
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