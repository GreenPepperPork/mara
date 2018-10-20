<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library;

require __DIR__ . '/base.php';
require LIB_PATH . DS . 'Loader.php';

$mode = require MARA_PATH . DS . 'common.php';

if (isset($mode)) {
    Loader::addNamespace($mode['NAMESPACE']);
}

// 自动注册
Loader::register();

// 注册错误和捕获异常
Error::register();

Config::set($mode);

Config::load(['/data/config']);

if (isset($mode[APP_CONF])) {
    Config::load($mode[APP_CONF]);
}

App::run();