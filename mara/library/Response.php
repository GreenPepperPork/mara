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
use mara\library\view\View;

/**
 * @method View RewritePageNotFindController()
 * @method View RewriteVerityController()
 * @method View RewriteHomeController()
 */
class Response
{
    use Singleton;

    public function __construct()
    {
    }

    public function redirect($url, $temporary = true, $quit = false)
    {
        header("Location: {$url}", true, $temporary ? 302 : 301);
        $quit and exit(0);
    }

    /**
     * 重定向到一些特殊页面
     *
     * @param $name
     * @param $arguments
     */
    function __call($name, $arguments)
    {
        $controller = strtr(strtoupper($name), ['Rewrite' => '']);
        // TODO 修改映射controller

        Loader::action([$controller, null]);
    }
}
