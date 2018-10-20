<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library;

use mara\library\exception\http\PageNotFindException;
use mara\library\exception\InstanceException;
use mara\library\view\Controller;

class Loader
{
    protected static $namespace = [];

    // 加载器注册
    public static function register($autoload = '')
    {
        spl_autoload_register($autoload ? $autoload : [__CLASS__, 'autoload']);
    }

    /**
     * 自动加载
     *
     * @param string  $class
     * @param boolean $auto
     * @return bool
     * @throws \Exception
     */
    public static function autoload($class, $auto = true)
    {
        $class = ltrim(str_replace(COMPACT_SYMBOL, '', $class, $compat), BS);

        if (!empty(self::$namespace)) {
            list($name, $class) = explode(BS, $class, 2);

            if (isset(self::$namespace[$name])) {
                $path = self::$namespace[$name];
            } else {
                throw new \Exception("{$class} `{$name}`" . ' namespace is not define');
            }
        }

        $basename = $path . DS . str_replace(BS, DS, $class);

        // TODO 可以做成单例加载
        if (is_file($filename = $basename . EXT)) {
            $auto && include $filename;
        } else if ($compat && is_file($filename = $basename . HTML_EXT)) {
            $auto && include $filename;
        }

        return $filename;
    }

    /**
     * 获取实例，可执行方法
     *
     * @param  string $class  类名
     * @param  string $method 方法名
     * @return mixed
     * @throws \Exception
     */
    public static function instance($class, $method = '')
    {
        static $_instance = [];
        $identity = $class . $method;

        if (!isset($_instance[$identity])) {
            if (class_exists($class)) {
                $object = new $class();
                if (!empty($method) && method_exists($object, $method)) {
                    $_instance[$identity] = [[&$object, $method]];
                } else {
                    $_instance[$identity] = $object;
                }
            } else {
                throw new \Exception('class not exist :' . $class, 10007);
            }
        }

        return $_instance[$identity];
    }

    /**
     * 添加命名空间，后续自动加载将根据namespace进行寻径
     *
     * @param array|string $namespace 命名空间
     * @param string       $path      路径
     */
    public static function addNamespace($namespace, $path = '')
    {
        if (is_array($namespace)) {
            self::$namespace = array_merge(self::$namespace, $namespace);
        } else {
            self::$namespace[$namespace] = $path;
        }
    }

    /**
     * 控制器实例化
     *
     * @param $class
     * @param string $layer
     * @return mixed
     * @throws InstanceException
     */
    public static function controller($class, $layer = '')
    {
        static $_instance = [];

        $class = $class . $layer;

        if (isset($_instance[$class])) {
            return $_instance[$class];
        }

        if (class_exists($class)) {
            $controller = new $class();
            $_instance[$class] = $controller;

            return $controller;
        }

        throw new InstanceException(sprintf('Class %s instance failed', $class));
    }

    /**
     * 远程调用模块的操作方法 参数格式 [模块/控制器/]操作
     *
     * @param mixed $dispatch 调度器
     * @return mixed
     * @throws InstanceException
     * @throws \Exception
     */
    public static function action($dispatch)
    {
        if ($dispatch instanceof Controller) {
            $controller  = $dispatch;
            $method      = Config::get('default_controller');
        } else if ($dispatch['controller'] instanceof Controller) {
            $controller = $dispatch['controller'];
            $method     = isset($dispatch['method']) ? $dispatch['method'] : Config::get('default_controller');
        } else {
            $controller = Loader::controller($dispatch['controller']);
            $method     = isset($dispatch['method']) ? $dispatch['method'] : Config::get('default_controller');
        }

        try {
            $controllerReflection = new \ReflectionObject($controller);
            if (!$controllerReflection->hasMethod($method)) {
                throw new PageNotFindException(sprintf('Controller %s don`t have method %s', $controllerReflection->getName(), $method));
            }

            $methodReflection = $controllerReflection->getMethod($method);
            if ($methodReflection->isAbstract() || !$methodReflection->isPublic()) {
                throw new InstanceException(sprintf('Controller has no access to method %s', $controllerReflection->getName(), $method));
            }

            return $methodReflection->invokeArgs($controller, []);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 解析应用类名称
     *
     * @param $name
     * @param $module
     * @param string $layer
     * @return string
     */
    public static function parseClass($name, $module, $layer = '')
    {
        $name = str_replace(['/', '.'], BS, $name);
        $array = explode(BS, $name);
        $path  = implode(BS, $array);

        // 命名限制,例如Controller
        if ($layer) {
            return BS . APP_NAMESPACE . BS . $module . BS . $layer . BS . $path . ucfirst($layer);
        }
        // 按照全路径进行解析
        return BS . APP_NAMESPACE . BS . $module . BS . $path;
    }
}
