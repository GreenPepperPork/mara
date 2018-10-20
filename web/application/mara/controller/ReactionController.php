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
    public function detailByUid()
    {
        try {
            $uid = $this->input('uid');
            if (empty($uid)) {
                Result::returnFailedResult("输入uid为空");
            }
            $reactionDao = new ReactionDao();
            $detail = $reactionDao->listByUid($uid);
            $bookDao=new BookDao();
            $commentDao=new CommentDao();
            foreach ($detail as $detail1){
                $book=$bookDao->getById($detail1->book_id);
                $detail1->bookName=$book->name;
                $detail1->images = "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1540066403599&di=6b1edc474435e4d75a52f3c551cddfbc&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2Fd439b6003af33a8754d7a023cd5c10385343b555.jpg";
                $detail1->commnets=$commentDao->getByreactionId($detail1->id);
            }
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
            $id = $this->post('id');
            $content = $this->post('content');
            if (empty($id) || empty($content)) {
                Result::buildFailedResult("传入数值为空");
            }
            $reactionDao=new ReactionDao();
            $updateArray = array('content' => $content);
            if (!empty($reactionDao->update($updateArray,$id))){
                Result::returnSuccessResult("编辑读后感成功");
            }else{
                Result::returnFailedResult("编辑读后感失败");
            }
        } catch (\Exception $e) {
            Result::buildFailedResult("系统级错误");
        }
    }
}
