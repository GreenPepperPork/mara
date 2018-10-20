<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
return [
    // 根目录
    'NAMESPACE' => [
        MARA              => MARA_PATH,
        APP_NAMESPACE     => APP_PATH,
        JOB_NAMESPACE     => JOB_PATH,
        STORAGE_NAMESPACE => STORAGE_PATH,
        'common'          => PUBLIC_PATH,
        'vendor'          => true
    ],

    // APP加载目录
    'APP_CONF' => [
        PUBLIC_PATH . DS . 'config',

        WEB_PATH . DS . 'config',
    ],

    // 类兼容表示符
    'CLASS_COMPAT' => '@',

    // 加载模板类
    'TPL_RECORD'        => TPL_PATH . '/record.tpl',
    'TPL_APP_EXCEPTION' => TPL_PATH . '/appException.tpl',

    'HTTP_URL'  => 'REQUEST_URI',

    'PAGE_VIEW'     => 'page',
    'FRAGMENT_VIEW' => 'fragment',

    'default_module'     => 'index',
    'default_controller' => 'index',
    'default_action'     => 'index',
];