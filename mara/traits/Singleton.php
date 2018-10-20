<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\traits;

use mara\library\exception\InstanceException;

/**
 * 单例Trait
 */
trait Singleton
{
    protected static $_instance;

    protected function __construct()
    {
    }

    /**
     * @return static
     * @throws InstanceException
     */
    public static function instance()
    {
        $class = get_called_class();
        $args  = func_get_args();

        if (!isset(static::$_instance)) {
            $classReflection = new \ReflectionClass($class);
            if (!$classReflection->isInstantiable()) {
                throw new InstanceException(sprintf('%s is not isInstantiable', $class));
            }

            static::$_instance = $classReflection->newInstance($args);
        }

        return static::$_instance;
    }
}