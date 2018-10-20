<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library;

class Config
{
    // 配置参数
    public static $config = [];
    // 参数作用域
    private static $range = '_sys_';

    /**
     * 加载配置文件
     *
     * @param mixed $files      配置文件名
     * @param bool $onlyInclude 是否只是加载文件
     * @return mixed
     */
    public static function load($files, $onlyInclude = false)
    {
        if (!empty($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if ($onlyInclude) {
                        include $file;
                    } else {
                        self::set(include $file, pathinfo($file, PATHINFO_FILENAME));
                    }
                } else if (is_dir($file)) {
                    // 加载目录
                    $scanFiles = array_diff(scandir($file), ['.', '..']);

                    foreach ($scanFiles as $scanFile) {
                        $loadFile = $file . DS . $scanFile;

                        if (is_file($loadFile) && $onlyInclude) {
                            include $loadFile;
                        } else if (is_file($loadFile)) {
                            self::set(include $loadFile, pathinfo($loadFile, PATHINFO_FILENAME));
                        }
                    }
                }
            }
        }
    }

    public static function set($value, $name = 'common')
    {
        $name  = $name ? strtolower($name) : null;

        if (is_null($name)) {
            return null;
        }

        if (is_array($value)) {
            self::$config[$name] = array_merge((array) (isset(self::$config[$name]) ? self::$config[$name] : []), $value);
        } else {
            self::$config[$name] = $value;
        }
    }

    public static function get($name = null, $range = 'common')
    {
        return $name ? self::$config[$range][$name] : self::$config[$range];
    }

    /**
     * 重置配置参数
     * @param string|boolean $range 清理范围，若为true则全部清空
     */
    public static function reset($range =  '')
    {
        $range = $range ? : self::$range;
        true === $range ? self::$config = [] : self::$config[$range] = [];
    }
}
