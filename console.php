#!/usr/bin/php
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
require VENDOR_PATH . DS . 'autoload.php';

$mode = require MARA_PATH . DS . 'common.php';

if (isset($mode)) {
    Loader::addNamespace($mode['NAMESPACE']);
}

// 自动注册
Loader::register();

// 注册错误和捕获异常
Error::register();

Config::set($mode);

if (isset($mode[APP_CONF])) {
    Config::load($mode[APP_CONF]);
}

Config::load(['/data/config']);

$class = JOB_NAMESPACE . '\\' . str_replace('_', '\\', getopt('', ['class::'])['class']);

// TODO 合并start.php和console.php,共用bootstrap
if (class_exists($class)) {
    (new $class)->init();
} else {
    die(sprintf("cant not find job %s\n", $class));
}