<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library\cache;

/**
 * 缓存驱动类
 */
abstract class Driver
{
    protected $handler = null;

    protected $options = [];

    protected $tag;

    /**
     * 判断缓存是否存在
     *
     * @param string $name 缓存变量名
     * @return bool
     */
    abstract public function has($name);

    /**
     * 读取缓存
     *
     * @param string $name 缓存变量名
     * @return mixed
     */
    abstract public function get($name);

    /**
     * 设置缓存
     *
     * @param string    $name   缓存变量名
     * @param mixed     $value  存储数据
     * @param int       $expire 有效时间 0为永久
     * @return boolean
     */
    abstract public function set($name, $value, $expire = null);

    /**
     * 删除缓存
     *
     * @param string $name 缓存变量名
     * @return boolean
     */
    abstract public function rm($name);

    /**
     * 清除缓存
     *
     * @param string $tag 标签名
     * @return boolean
     */
    abstract public function clear($tag = null);

    /**
     * 读取缓存并删除
     *
     * @param string $name 缓存变量名
     * @return mixed
     */
    public function pop($name)
    {
        $result = $this->get($name, false);
        if ($result) {
            $this->rm($name);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * 如果不存在则写入缓存
     *
     * @param string    $name 缓存变量名
     * @param mixed     $value  存储数据
     * @param int       $expire  有效时间 0为永久
     * @return mixed
     */
    public function remember($name, $value, $expire = null)
    {
        if (!$this->has($name)) {
            if ($value instanceof \Closure) {
                $value = call_user_func($value);
            }
            $this->set($name, $value, $expire);
        } else {
            $value = $this->get($name);
        }
        return $value;
    }

    /**
     * 返回句柄对象，可执行其它高级方法
     *
     * @return object
     */
    public function handler()
    {
        return $this->handler;
    }

    /**
     * 获取实际的缓存标识
     *
     * @param string $name 缓存名
     * @return string
     */
    protected function getCacheKey($name)
    {
        return $this->options['prefix'] . $name;
    }
}
