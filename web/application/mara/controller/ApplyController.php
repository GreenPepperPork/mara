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
use app\mara\dao\ApplyDao;
use app\mara\dao\BookDao;
use app\mara\dao\MemberDao;
use app\mara\model\ApplyModel;
use mara\library\view\Controller;

class ApplyController extends Controller
{
    /**
     * 新增借书申请
     */
    public function add()
    {
        try {
            $bookId = $this->input('bookid');
            $applyUid = $this->input('applyuid');
            $ownerId = $this->input("owneruid");
            $content= $this->input("content");
            if (empty($bookId) || empty($applyUid) || empty($ownerId)) {
                Result::returnFailedResult("传入参数为空");
            }
            $applyDao = new ApplyDao();
            $applyModel = new ApplyModel();
            $applyModel->owner_uid = $ownerId;
            $applyModel->apply_uid = $applyUid;
            $applyModel->book_id = $bookId;
            $applyModel->is_read = 0;
            $applyModel->gmt_modified = time();
            $applyModel->gmt_create = time();
            $applyModel->content=$content;
            if (!empty($applyDao->insert($applyModel))) {
                Result::returnSuccessResult("增加申请成功");
            } else {
                Result::returnFailedResult("增加申请失败");
            }
        } catch (\Exception $e) {
            Result::returnFailedResult("增加申请失败请求系统失败");
        }


    }

    /**
     * 查看别人对我的借书申请列表
     *
     * @throws \Exception
     */
    public function ownerApply()
    {
        $uid = $this->input('uid');

        $applyDao = new ApplyDao();
        $bookDao=new BookDao();
        $memDao=new MemberDao();

        $list = $applyDao->listByOwnerUid($uid);
        foreach ($list as $oneList){
            $bookRow=$bookDao->getById($oneList->book_id);
            $oneList->bookName=$bookRow->name;
            $ownerRow=$memDao->getById($oneList->owner_uid);
            $oneList->ownerName=$ownerRow->name;
            $applyRow=$memDao->getById($oneList->apply_uid);
            $oneList->applyName=$applyRow->name;
            $oneList->content=$applyRow->content;
        }
        print_r($list);
        die;

        Result::returnSuccessResult($list);
    }

    /**
     * 查看我对别人借书申请列表
     *
     * @throws \Exception
     */
    public function myApply()
    {
        $uid = $this->input('uid');

        $applyDao = new ApplyDao();

        $list = $applyDao->listByApplyUid($uid);

        // TODO 将list中的owner_uid转换为具体用户信息

        // TODO 将list中的apply_uid转换为具体用户信息

        // TODO 将list中的book_id转换为具体书本信息

        Result::returnSuccessResult($list);
    }

    public function allApply()
    {
        $uid = $this->input('uid');

        $applyDao = new ApplyDao();

        $list = $applyDao->listAllApplyUid($uid);

        // TODO 将list中的owner_uid转换为具体用户信息
        // TODO 将list中的apply_uid转换为具体用户信息
        // TODO 将list中的book_id转换为具体书本信息

        Result::returnSuccessResult($list);
    }
}
