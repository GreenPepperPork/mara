<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace app\mara\controller;

use app\common\assembly\Result;
use app\mara\dao\BookDao;
use mara\library\view\Controller;

class IndexController extends Controller
{
    /**
     * 每页默认页数
     */
    const DEFAULT_SIZE = 20;

    /**
     * 首页 - 找书
     * @throws \Exception
     */
    public function index()
    {
        $page = $this->input('page', 1);
        $size = $this->input('size', self::DEFAULT_SIZE);

        // 获取书本列表
        $bookDao = new BookDao();
        $bookList = $bookDao->listBook($page, $size);

        Result::returnSuccessResult([
            'list' => $bookList
        ]);
    }
}