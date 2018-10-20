<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
// 路由配置
return [
    // 问题首页
    'app\mara\controller\MemberController' => [
        // 登陆接口
        'login' => ['\/bf\/member\/login'],
        // 注册登录接口
        'registry' => ['\/bf\/member\/registry'],
        // 个人中心 -- 个人详情
        'detail' => ['\/bf\/member\/detail'],
        // 测试
        'test' => ['\/bf\/member\/test'],
    ],
    'app\mara\controller\IndexController' => [
        // 首页 - 找书
        'index' => ['\/bf\/index']
    ],
    'app\mara\controller\ReactionController' => [
        // 首页 - 找书
        'my' => ['\/bf\/reaction\/my']
    ]
];
