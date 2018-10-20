<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace app\mara\controller;

use app\common\assembly\Encrypt;
use app\common\assembly\MaraImage;
use app\common\assembly\Result;
use mara\library\Config;
use mara\library\Request;
use mara\library\view\Controller;
use storage\model\cache\OptionModel;
use storage\model\cache\QuestionModel;

class MemberController extends Controller
{
    /**
     * 登陆页面
     */
    public function login()
    {
        $account  = $this->input('account');
        $password = $this->input('password');

        // TODO 改成统一校验类进行校验
        if (empty($account) || empty($password)) {
            Result::returnFailedResult('请输入有效的帐号/密码');
        }

        $member = ['uid' => 10086, 'nickname' => '应果真'];
        Result::returnSuccessResult($member);
    }

    /**
     * 注册页面
     */
    public function registry()
    {
        $account         = $this->input('account');
        $nickname        = $this->input('nickname');
        $password        = $this->input('password');
        $password_repeat = $this->input('password_repeat');

        // TODO 改成统一校验类进行校验
        if (empty($account) || empty($nickname) || empty($password) || empty($password_repeat)) {
            Result::returnFailedResult('请填写有效的帐号/昵称');
        }

        $member = ['uid' => 10086, 'nickname' => '应果真'];
        Result::returnSuccessResult($member);
    }
}