<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace mara\library;

use mara\library\exception\RouteException;

class Router
{
    /**
     * 解析模块的Path
     *
     * @param string $path Url-path信息
     * @return string
     * @throws RouteException
     * @throws exception\InstanceException
     */
    public static function parsePath($path = '')
    {
        $match = self::match($path);

        if (!isset($match[0])) {
            throw new RouteException('Route Redirect Failed!');
        }

        $dispatch['controller'] = Loader::controller($match[0]);
        $dispatch['method']     = isset($match[1]) ? $match[1] : Config::get('default_action');
        $dispatch['params']     = isset($match[2]) ? $match[2] : [];

        return $dispatch;
    }

    /**
     * TODO 路由规则需要支持REST
     *
     * @param $url
     * @return array|bool
     * @throws exception\InstanceException
     */
    public static function match($url)
    {
        $path = $url ?: Request::instance()->getPath();

        $routeMap = Config::get(null, 'route');

        if (!empty($routeMap)) {
            foreach ($routeMap as $controller => $route) {
                foreach ($route as $action => $rules) {
                    foreach ($rules as $rule) {
                        if (preg_match("/{$rule}/", $path, $matches)) {
                            Request::instance()->setMatches($matches);
                            return [$controller, $action];
                        }
                    }
                }
            }
        }

        Response::instance()->RewritePageNotFindController();
    }
}
