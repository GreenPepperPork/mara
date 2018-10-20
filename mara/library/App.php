<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace mara\library;

class App
{
    /**
     * 入口主函数
     *
     * @param Request $request
     * @param Response $response
     * @throws \Exception
     * @throws exception\InstanceException
     */
    public static function run($request = null, $response = null)
    {
        is_null($request) and $request = Request::instance();
        is_null($response) and $response = Response::instance();

        // 是否显示调试堆栈信息
        defined('DEBUG_TRACE') or define('DEBUG_TRACE', $request->input(DEBUG_TRACE_SWITCH));

        $dispatch = self::route($request);

        Loader::action($dispatch);
        // 监听并执行注册事件
        Hook::listen('shutdown');
    }

    /**
     * @param $request
     * @return mixed
     * @throws exception\RouteException
     * @throws exception\InstanceException
     */
    public static function route($request)
    {
        $path = $request instanceof Request ? $request->getPath() : $request;

        // 解析地址
        $result = Router::parsePath($path);

        return $request->dispatch($result);
    }
}
