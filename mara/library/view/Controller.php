<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace mara\library\view;

use mara\library\Componet;
use mara\library\exception\InstanceException;
use mara\library\Loader;
use mara\library\Request;
use mara\library\Response;

class Controller extends View
{
    // 模板变量
    protected $data = [];

    function __construct() {}

    /**
     * fetch 有问题
     *
     * @return bool
     * @throws \Exception
     */
    public function fetch()
    {
        $callInfo = $this->getCalledInfo();
        $class = str_ireplace(CONTROLLER_LAYER, PAGE_LAYER, $callInfo['__NAMESPACE__']) . BS . $callInfo['__CONTROLLER__'] . BS . ACTION_NAME;

        $loadPage = Loader::autoload(COMPACT_SYMBOL . $class, false);

        // 布局加载
        if ($layout = Loader::action([$this, 'layout'])) {
            $args = (array) $layout[1] + $this->get() + ['__LOAD_PAGE__' => $loadPage];
            return Componet::render($layout[0], $args);
        }

        return $loadPage;
    }

    public function display($url = '')
    {
        include $this->fetch();
    }

    public function json($data, $charset = 'utf8')
    {
        header("content-type:application/json;charset={$charset}");
        die(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function input($key, $default = null)
    {
        try {
            $value = Request::instance()->input($key);
            return !is_null($value) ? $value : $default;
        } catch (InstanceException $e) {
            return null;
        }
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function post($key, $default = null)
    {
        $value = $_POST[$key];

        return !is_null($value) ? $value : $default;
    }
}
