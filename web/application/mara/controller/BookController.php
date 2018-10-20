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
use app\mara\model\BookModel;
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
        try {

            $name = $this->post('name');
            $brief = $this->post('brief');
            $reaction = $this->post('reaction');
            $cover = $this->post('cover');
            $images = $this->post('images', '');
            $status = $this->post('status');
            $ownerUid = $this->post('owner_uid');
            $isRent = $this->post('is_rent');
            if (empty($name) || empty($brief) || empty($reaction) || empty($cover) || empty($images) || empty($status) || empty($ownerUid) || empty($isRent)) {
                Result::returnFailedResult("输入参数为空");
            }
            $bookModel = new BookModel();
            $bookModel->name = $name;
            $bookModel->brief = $brief;
            $bookModel->reaction = $reaction;
            $bookModel->cover = $cover;
            $bookModel->images = $images;
            $bookModel->status = $status;
            $bookModel->owner_uid = $ownerUid;
            $bookModel->is_rent = $isRent;
            $bookDao = new BookDao();
            if (!empty($bookDao->insert($bookModel))) {
                Result::returnSuccessResult("插入书本成功");
            } else {
                Result::returnFailedResult("插入书本失败");
            }
        } catch (\Exception $e) {
                Result::returnFailedResult("系统级错误");
        }
    }

    /**
     * 图书 - 编辑图书
     *
     * @throws \Exception
     */
    public function edit()
    {

        try {
            $id = $this->post('id');
            $name = $this->post('name');
            $brief = $this->post('brief');
            $reaction = $this->post('reaction');
            $cover = $this->post('cover');
            $images = $this->post('images', '');
            $status = $this->post('status');
            $isRent = $this->post('is_rent');
            if (empty($name) || empty($brief) || empty($reaction) || empty($cover) || empty($images) || empty($status) || empty($ownerUid) || empty($isRent)) {
                Result::returnFailedResult("输入参数为空");
            }
            $updateArray = new BookModel();
            $updateArray->name = $name;
            $updateArray->brief = $brief;
            $updateArray->reaction = $reaction;
            $updateArray->cover = $cover;
            $updateArray->images = $images;
            $updateArray->status = $status;
            $updateArray->owner_uid = $ownerUid;
            $updateArray->is_rent = $isRent;
            $bookDao = new BookDao();
            if (!empty($bookDao->where(['id' => $id])->update($updateArray))) {
                Result::returnSuccessResult("编辑图书成功");
            } else {
                Result::returnFailedResult("编辑图书失败");
            }
        } catch (\Exception $e) {
            Result::returnFailedResult("系统级错误");
        }
    }
}
