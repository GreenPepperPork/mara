<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library\exception;

/**
 * 加载配置异常类
 */
class ConfigException extends \Exception
{
    /**
     * @var string 加载的key
     */
    protected $key;

    /**
     * @var string 加载的文件名
     */
    protected $file;

    /**
     * @param string $key
     * @param int $file
     */
    function __construct($key, $file)
    {
        if (!is_readable($file)) {
            $this->message = "File {$file} can not access!";
            return;
        }

        $this->message = "File : {$file} can not find key {$key}";
    }
}
