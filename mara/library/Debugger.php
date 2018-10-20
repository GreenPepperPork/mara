<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library;

use mara\traits\Singleton;

class Debugger
{
    use Singleton;

    CONST TYPE_MSG = 'message';

    CONST TYPE_WARN = 'warn';

    private $memoryLevel = ['', 'KB', 'MB', 'GB'];

    public static $enable;

    public static $info;

    public function __construct()
    {
        $this->enable();

        // 新增注销函数
        Hook::add('shutdown', [$this, 'shutdown']);
    }

    /**
     * 程序注销执行函数
     */
    public function shutdown()
    {
        // TODO 新增调试页面用于记录页面信息
    }

    /**
     * 设置是否开启调试
     *
     * @param mixed $switch
     * @return boolean
     */
    public function enable($switch = DEBUG_TRACE)
    {
        self::$enable = (boolean) $switch;
    }

    /**
     * 调试信息[警告]
     *
     * @param string $point 断点
     * @param string $info  调试信息
     */
    public function warn($point, $info = '')
    {
        self::$enable AND self::$info[self::TYPE_WARN][] = self::point($info, $point);
    }

    /**
     * 信息调试信息
     *
     * @param string $point 断点
     * @param string $info  调试信息
     * @param string $type  调试类型
     */
    public function info($point, $info = '', $type = self::TYPE_MSG)
    {
        self::$enable AND self::$info[$type][$point] = self::point($info, $point);
    }

    /**
     * 获取调试信息
     *
     * @param  string $type  debug|benchmark
     * @return array
     */
    public function get($type = '')
    {
        return empty($type) ? self::$info : self::$info[$type];
    }

    /**
     * 获取两个调试点调试信息差
     *
     * @param string $start 开始调试点
     * @param string $end   结束调试点
     * @param string $level 内存等级
     * @return array
     */
    public function diff($start, $end, $level = 'MB')
    {
        $startPoint = $this->getPoint($start);
        $endPoint   = $this->getPoint($end);

        return [
            'time'   => $endPoint['time'] - $startPoint['time'],
            'memory' => ($endPoint['memory'] - $startPoint['memory']) / pow(1024, (int) array_search($level, $this->memoryLevel))
        ];
    }

    /**
     * 获取当前调试器种类
     *
     * @return array
     */
    public function getTypes()
    {
        return array_keys(self::$info);
    }

    public function getPoint($point, $type = self::TYPE_MSG)
    {
        return $this->get($type)[$point];
    }

    /**
     * 设置调试信息点
     *
     * @param string $info  调试信息
     * @param string $point 断点
     * @return array
     */
    private function point($info, $point)
    {
        return [
            'info'   => $info,
            'time'   => microtime(true),
            'memory' => memory_get_usage(),
            'point'  => $point
        ];
    }
}