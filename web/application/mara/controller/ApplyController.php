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
use app\mara\dao\MemberDao;
use app\mara\dao\ReactionDao;
use app\mara\model\MemberModel;
use mara\library\view\Controller;

class ApplyController extends Controller
{
    /**
     * 新增借书申请
     */
    public function add()
    {
        $bookId = $this->post('book_id');
        $applyUid = $this->post('apply_uid');

        // TODO 检测值

        // TODO 新增申请

        Result::returnSuccessResult();
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

        $list = $applyDao->listByOwnerUid($uid);

        // TODO 将list中的owner_uid转换为具体用户信息
        // TODO 将list中的apply_uid转换为具体用户信息
        // TODO 将list中的book_id转换为具体书本信息

        Result::returnSuccessResult($list);
    }

    /**
     * 查看别人对我的借书申请列表
     *
     * @throws \Exception
     */
    public function applyApply()
    {
        $uid = $this->input('uid');

        $applyDao = new ApplyDao();

        $list = $applyDao->listByOwnerUid($uid);

        // TODO 将list中的owner_uid转换为具体用户信息
        // TODO 将list中的apply_uid转换为具体用户信息
        // TODO 将list中的book_id转换为具体书本信息

        Result::returnSuccessResult($list);
    }
}
