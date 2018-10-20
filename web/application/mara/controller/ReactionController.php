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
use app\mara\dao\MemberDao;
use app\mara\dao\ReactionDao;
use app\mara\model\MemberModel;
use mara\library\view\Controller;

class ReactionController extends Controller
{
    /**
     * 我的读后感
     */
    public function my()
    {
        $uid = $this->input('uid');

        // TODO EMPTY UID

        $reactionDao = new ReactionDao();
        $list = $reactionDao->listByUid($uid);

        Result::returnSuccessResult($list);
    }

    /**
     * 读后感详情
     */
    public function detail()
    {
        $id = $this->input('id');

        // TODO EMPTY UID

        $reactionDao = new ReactionDao();
        $detail = $reactionDao->listById($id);

        Result::returnSuccessResult($detail);
    }

    /**
     * 新增读后感
     */
    public function add()
    {
    }

    /**
     * 读后感编辑
     */
    public function edit()
    {
    }
}
