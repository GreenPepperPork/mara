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

class BookController extends Controller
{
    /**
     * 每页默认页数
     */
    const DEFAULT_SIZE = 20;

    /**
     * 图书 - 首页找书
     *
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

    /**
     * 图书 - 详情
     *
     * @throws \Exception
     */
    public function detail()
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

    /**
     * 图书 - 新增图书
     *
     * @throws \Exception
     */
    public function add()
    {
        $name = $this->post('name');
        $brief = $this->post('brief');
        $reaction = $this->post('reaction');
        $cover = $this->post('cover');
        $images = $this->post('images', '');
        $status = $this->post('status');
        $ownerUid = $this->post('owner_uid');
        $isRent = $this->post('is_rent');

        // TODO 检测值

        // TODO 新增图书

        Result::returnSuccessResult();
    }

    /**
     * 图书 - 编辑图书
     *
     * @throws \Exception
     */
    public function edit()
    {
        $name = $this->post('name');
        $brief = $this->post('brief');
        $reaction = $this->post('reaction');
        $cover = $this->post('cover');
        $images = $this->post('images', '');
        $status = $this->post('status');
        $isRent = $this->post('is_rent');

        // TODO 检测值

        // TODO 修改图书

        Result::returnSuccessResult();
    }
}