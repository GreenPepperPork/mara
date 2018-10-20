<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace mara\library;

class Componet
{
    const METHOD = '_load';

    /**
     * 加载组件页面(加载文件[php, phtml])
     *
     * @param $path
     * @param array $config
     * @param string $module
     * @return bool
     */
    public static function render($path, $config = [], $module = '')
    {
        $method = isset($config['__METHOD']) ? $config['__METHOD'] : self::METHOD;

        if (!$module) {
            list($module, $path) = explode('.', $path, 2);
        }

        // 根据路径解析类
        $class = Loader::parseClass($path, $module);

        // TODO 调用机制需进一步调整
        try {
            Loader::autoload(COMPACT_SYMBOL . $class);
            if (class_exists($class, false)) {
                // 如果此类存在, 则路由到对应的PHP文件中
                call_user_func_array([Loader::instance($class), $method], [$config]);
            }
        } catch (\Exception $e) {
            trigger_error($e->getMessage());
        }

        return true;
    }

    /**
     * @param $path
     * @param array $infos
     * @return mixed
     */
    public static function load($path, $infos = [])
    {
        if (is_file($path)) {
            include $path;
        } else {
            trigger_error($path . ' is not exsist.');
        }
    }
}