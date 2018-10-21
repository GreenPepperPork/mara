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
use app\mara\dao\MemberDao;
use app\mara\dao\ReactionDao;
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
        $key = $this->input('key', '');

        // 获取书本列表
        $bookDao = new BookDao();
        $memberDao=new MemberDao();
        $bookList = $bookDao->listBook($page, $size, $key);
        foreach ($bookList as $book){
            $row=$memberDao->getById($book->owner_uid);
            $book->ownerName=$row->name;
            $book->headicon=$row->head_icon;
        }
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
        $id = $this->input('id');

        // 获取书本列表
        $bookDao = new BookDao();
        $book = $bookDao->getById($id);

        // 读后感列表
        $reactionDao = new ReactionDao();
        $reactionList = $reactionDao->listByBookId($id);

        if (!empty($reactionList)) {
            $uids = array_column($reactionList, 'uid');
            $memberDao = new MemberDao();
            $memberList = $memberDao->getByIds($uids);
            if (!empty($memberList)) {
                $memberList = array_combine(array_column($memberList, 'id'), $memberList);

                foreach ($reactionList as $reaction) {
                    $reaction->nickname = $memberList[$reaction->uid]->name;
                    $reaction->head_icon = $memberList[$reaction->uid]->head_icon;
                }
            }
        }else{
            Result::returnFailedResult("查询详情页失败");
        }

        Result::returnSuccessResult([
            'book_detail' => $book,
            'reaction_list' => $reactionList
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

            $name = $this->input('name');
            $brief = $this->input('brief');
            $reaction = $this->input('reaction');
            $cover = $this->input('cover');
            $images = $this->input('images', '');
            $status = 1;
            $ownerUid = $this->input('owner_uid');
            $isRent = $this->input('is_rent');
            $author = $this->input('author');
            if (empty($name) || empty($brief) || empty($reaction) || empty($status) || empty($ownerUid) || empty($isRent)||empty($author)) {
                Result::returnFailedResult("输入参数缺失");
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
            $bookModel->rent_uid=1;
            $bookModel->comment_count=0;
            $bookModel->gmt_create=time();
            $bookModel->gmt_modified=time();
            $bookModel->reaction_count=0;
            $bookModel->author=$author;
            $bookDao = new BookDao();
            if (!empty($bookDao->insert($bookModel))) {
                Result::returnSuccessResult("插入书本成功");
            } else {
                Result::returnFailedResult("插入书本失败");
            }
        } catch (\Exception $e) {
            print_r($e);
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
            $gmtModified= time();

            if (empty($name) && empty($brief) && empty($reaction) && empty($cover) && empty($images) && empty($status) && empty($isRent) && empty($gmtModified)) {
                Result::returnFailedResult("输入参数为空");
            }
            $updateArray = new BookModel();
            $updateArray = array('name' => $name,'brief'=>$brief,'reaction'=>$reaction,'cover'=>$cover,'images'=>$images,'status'=>$status,'is_rent'=>$isRent,'gmt_modified'=>$gmtModified);
            $bookDao = new BookDao();
            if (!empty($bookDao->update($updateArray,$id))) {
                Result::returnSuccessResult("编辑图书成功");
            } else {
                Result::returnFailedResult("编辑图书失败");
            }
        } catch (\Exception $e) {
            Result::returnFailedResult("系统级错误");
        }
    }
}
