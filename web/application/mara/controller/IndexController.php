<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace app\mara\controller;

use mara\library\view\Controller;

class IndexController extends Controller
{
    /**
     * 每页默认页数
     */
    const DEFAULT_SIZE = 20;

    /**
     * 首页 - 找书
     */
    public function index()
    {
        $page = $this->input('page', 1);
        $size = $this->input('size', self::DEFAULT_SIZE);


    }
}