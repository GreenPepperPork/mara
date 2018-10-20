<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library;

use mara\library\exception\InstanceException;

/**
 * 缓存类
 *
 * @method \Memcached memcached($type, array $options = [])
 * @method \Redis     redis($type, array $options = [])
 * @method \Yac       yac($type, array $options = [])
 */
class Cache
{
    /**
     * @var mixed 操作句柄
     */
    protected static $handler;

    /**
     * @param string $type      缓存驱动类型
     * @param array  $options   缓存选项
     * @throws InstanceException
     */
    public static function init($type, $options = [])
    {
        $drive = MARA . BS . 'storage' . BS . $type;

        if (!class_exists($drive)) {
            throw new InstanceException("Cant not find {$type} storage!");
        }

        self::$handler[$type] = new $drive($options);
    }

    function __callStatic($type, $arguments)
    {
        if (!isset(self::$handler[$type])) {
            $arguments = is_array($arguments) ? reset($arguments) : [];
            self::init($type, $arguments);
        }

        return self::$handler[$type];
    }
}
