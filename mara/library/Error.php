<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library;

use mara\library\exception\ViewException;

class Error
{
    public static function register()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        defined(APP_DEBUG) && ini_set('display_errors', 'on');

        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'autoShutDownFunc']);
    }

    /**
     * @param $level
     * @param $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @throws exception\InstanceException
     */
    public static function appError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() && defined('DEBUG_TRACE')) {
            Debugger::instance()->warn($file, $message);
        }
    }

    public static function appException(\Throwable $throwable)
    {
        // TODO 可以通过注入的方式解决依赖
        self::getExceptionHandler()->report($throwable);

        if ($throwable instanceof ViewException) {
            self::getExceptionHandler()->render(Config::get('TPL_APP_EXCEPTION'));
        } else if (defined(DEBUG_TRACE_SWITCH)) {
            self::getExceptionHandler()->render(Config::get('TPL_APP_EXCEPTION'));
        } else {
            echo "File: {$throwable->getFile()}, line : {$throwable->getLine()}, {$throwable->getMessage()}";
        }
    }

    /**
     * @throws exception\InstanceException
     */
    public static function autoShutDownFunc()
    {
        if (defined('DEBUG_TRACE') && DEBUG_TRACE) {
            Componet::load(Config::get('TPL_RECORD'), Debugger::instance()->get());
        }
    }

    public static function getExceptionHandler()
    {
        static $handler;

        if (empty($handler)) {
            $class = Config::get('Exception_Handler');
            if (class_exists($class)) {
                $handler = $class;
            } else {
                $handler = new Handle();
            }
        }

        return $handler;
    }
}
