<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

date_default_timezone_set('PRC');
// 系统信息
define('SYS_TIME', microtime(true));
define('SYS_MEM', memory_get_usage());
define('MARA', 'mara');

// 版本信息
define('VERSION', '0.0.1');

// 系统常量
define('DS', DIRECTORY_SEPARATOR);
define('BS', '\\');
define('EXT', '.php');
define('TPL_EXT', '.tpl');
define('HTML_EXT', '.phtml');
define('COMPACT_SYMBOL', '@');
define('CONTROLLER_LAYER', 'controller');
define('PAGE_LAYER', 'page');
define('APP_NAMESPACE', 'app');
define('JOB_NAMESPACE', 'job');
define('STORAGE_NAMESPACE', 'storage');
define('AUTO_LOAD', true);
define('APP_DEBUG', true);
define('DEBUG_TRACE_SWITCH', 'debug');

// 环境变量
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
define('MARA_PATH', ROOT_PATH . DS . 'mara');
define('WEB_PATH', ROOT_PATH . DS . 'web');
define('JOB_PATH', ROOT_PATH . DS . 'job');
define('STORAGE_PATH', ROOT_PATH . DS . 'storage');
define('VENDOR_PATH', ROOT_PATH . DS . 'vendor');
define('LIB_PATH', MARA_PATH . DS . 'library');
define('APP_PATH', WEB_PATH . DS . 'application');
define('PUBLIC_PATH', MARA_PATH . DS . 'public');
define('TPL_PATH', PUBLIC_PATH . DS . 'tpl');
define('CACHE_PATH', '/tmp');

// 配置类参数
define('APP_CONF', 'APP_CONF');
define('COMMON_CONF', LIB_PATH . DS . 'common.php');