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
        // 读后感 - 我的读后感
        'my' => ['\/bf\/reaction\/my'],
        // 读后感 - 读后感详情
        'detail' => ['\/bf\/reaction\/detail'],
        // 读后感 - 新增
        'add' => ['\/bf\/reaction\/add'],
        // 读后感 - 编辑
        'edit' => ['\/bf\/reaction\/edit']
    ]
];
