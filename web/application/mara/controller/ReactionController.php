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
use app\mara\dao\CommentDao;
use app\mara\dao\ReactionDao;
use app\mara\model\ReactionModel;
use mara\library\view\Controller;

class ReactionController extends Controller
{
    /**
     * 我的读后感
     */
    public function my()
    {

        try {
            $uid = $this->input('uid');
            if (empty($uid)) {
                Result::returnFailedResult("输入uid为空");
            }
            $reactionDao = new ReactionDao();
            $list = $reactionDao->listByUid($uid);
            if (!empty($list)){
                Result::returnSuccessResult($list);
            }
        } catch (\Exception $e) {
            Result::buildFailedResult("系统级错误");
        }
    }

    /**
     * 读后感详情根据uid
     */
    public function detailById()
    {
        try {
            $id = $this->input('id');
            if (empty($id)) {
                Result::returnFailedResult("输入id为空");
            }
            $reactionDao = new ReactionDao();
            $detail = $reactionDao->getById($id);
            $bookDao = new BookDao();
            $commentDao = new CommentDao();
            $book = $bookDao->getById($detail->book_id);
            $detail->bookName = $book->name;
            $detail->images = "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1540067621393&di=abdcdb0ae4f4632ed19990451e254cce&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2F35a85edf8db1cb1345ac812ad654564e93584bc5.jpg";
            $detail->commnets = $commentDao->getByreactionId($detail->id);
            $detail->author =$book->author;
            Result::returnSuccessResult($detail);
        } catch (\Exception $e) {
            Result::buildFailedResult("系统级错误");
        }
    }

    /**
     * 新增读后感
     */
    public function add()
    {
        try {
            $bookId = $this->post('book_id');
            $uid = $this->post('uid');
            $content = $this->post('content');
            if (empty($bookId) || empty($uid) || empty($content) || empty($content)) {
                Result::returnFailedResult("传入数据为空");
            }
            $reactionDao = new ReactionDao();
            $reactionModel = new ReactionModel();
            $reactionModel->uid = $uid;
            $reactionModel->book_id= $bookId;
            $reactionModel->content = $content;
            $reactionModel->gmt_create=time();
            $reactionModel->gmt_modified=time();
            if (!empty($reactionDao->insert($reactionModel))) {
                Result::returnSuccessResult("","新增读后感成功");
            } else {
                Result::returnFailedResult("新增读后感失败");
            }
        } catch (\Exception $e) {
            print_r($e);
            Result::buildFailedResult("系统级错误");
        }

    }

    /**
     * 读后感编辑
     */
    public function edit()
    {
        try {
            $id = $this->input('id');
            $content = $this->input('content');
            if (empty($id) || empty($content)) {
                Result::returnFailedResult("传入数值为空");
            }
            $reactionDao=new ReactionDao();
            $updateArray = array('content' => $content);
            if (!empty($reactionDao->update($updateArray,$id))){
                $data=new \stdClass();
                $row=$reactionDao->getById($id);
                $data->book_id=$row->book_id;
                Result::returnSuccessResult($data,"编辑读后感成功");
            }else{
                Result::returnFailedResult("编辑读后感失败");
            }
        } catch (\Exception $e) {
            Result::returnFailedResult("系统级错误");
        }
    }
}
