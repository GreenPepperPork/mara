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

/**
 * @method string getScheme()
 * @method string getHost()
 * @method string getPort()
 * @method string getPath()
 * @method string getQuery()
 */
class Request
{
    use Singleton;

    // 调度器
    protected $dispatch = null;

    protected $path = null;

    protected $pathinfo;

    protected $attribute;

    protected $matches;

    public function __construct()
    {
    }

    /**
     * 设置请求类参数值(全局变量)
     *
     * @param string $name
     * @param mixed  $value
     * @return mixed
     */
    public function set($name, $value)
    {
        return $this->attribute[$name] = $value;
    }

    /**
     * 获取请求类参数值
     *
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return isset($this->attribute[$name]) ? $this->attribute[$name] : null;
    }

    /**
     * 获取页面请求参数
     *
     * @param string $input
     * @return mixed
     */
    public function input($input = '')
    {
        static $request;

        if (is_null($request)) {
            $request = $_GET + $_POST + $_REQUEST;
        }

        return isset($request[$input]) ? $request[$input] : null;
    }

    /**
     * 获取当前请求的URL
     *
     * @return string
     */
    public function url()
    {
        $httpTag = Config::get('HTTP_URL');

        return isset($_SERVER[$httpTag]) ? $_SERVER[$httpTag] : '';
    }

    /**
     * 当前URL的访问后缀
     *
     * @access public
     * @return string
     */
    public function ext()
    {
        return pathinfo($this->getPath(), PATHINFO_EXTENSION);
    }

    /**
     * 设置路由匹配结果
     *
     * @param array|null $matches
     */
    public function setMatches($matches)
    {
        $this->matches = $matches;
    }

    /**
     * 获取当前路由的匹配结果
     *
     * @return mixed
     */
    public function getMatches()
    {
        return $this->matches;
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * 响应类调度器
     *
     * @param  mixed $dispatch
     * @return mixed
     */
    public function dispatch($dispatch = null)
    {
        if (!empty($dispatch)) {
            $this->dispatch = $dispatch;
        }

        return $this->dispatch;
    }

    /**
     * 判断是否为https
     */
    public function isSecure()
    {
        $secures = Config::get('secure');

        foreach ($secures as $var => $secure) {
            if (isset($_SERVER[$var]) && $_SERVER[$var] == $secure) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取url基础信息
     *
     * @param $name
     * @param $arguments
     * @return mixed|null
     */
    public function __call($name, $arguments)
    {
        $constant = constant('PHP_URL_' . strtr(strtoupper($name), ['GET' => '']));

        if (is_null($constant)) {
            return null;
        }

        return parse_url($this->url(), $constant);
    }
}
