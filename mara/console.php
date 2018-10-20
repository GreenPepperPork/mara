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
        MARA           => MARA_PATH,
        JOB_NAMESPACE  => JOB_PATH,

        'common'       => PUBLIC_PATH,
        'vendor'       => true
    ],

    // APP加载目录
    'APP_CONF' => [
        PUBLIC_PATH . DS . 'config.php',
        APP_PATH . DS . 'config.php',

        PUBLIC_PATH . DS . 'database.php'
    ],

    // 类兼容表示符
    'CLASS_COMPAT' => '@',

    // 加载模板类
    'TPL_RECORD'        => TPL_PATH . '/record.tpl',
    'TPL_APP_EXCEPTION' => TPL_PATH . '/appException.tpl',
];