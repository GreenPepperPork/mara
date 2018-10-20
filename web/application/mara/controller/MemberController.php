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
use app\mara\model\MemberModel;
use mara\library\view\Controller;

class MemberController extends Controller
{
    const head_icon="";
    const sex=0;
    /**
     * 登陆页面
     */
    public function login()
    {

        try {
            $account = $this->input('account');
            $password = $this->input('password');// TODO 改成统一校验类进行校验
            if (empty($account) || empty($password)) {
                Result::returnFailedResult('请输入有效的帐号/密码');
            }
            $memberDao = new MemberDao();
            $row = $memberDao->getByAccountAndPassword($account,$password);
            if (empty($row)) {
                Result::returnFailedResult('账号不存在');
            } else {
                $data=new \stdClass();
                $data->uid=$row[0]->id;
                $data->nickname=$row[0]->name;
                session_start();
                $_SESSION['uid'] = $data->uid;
                session_commit();
                $_COOKIE['uid'] = $data->uid;
                Result::returnSuccessResult($data, "登录成功");
            }
        } catch (\Exception $e) {
            Result::returnFailedResult('登录系统请求错误');
        }
    }

    /**
     * 注册页面
     */
    public function registry()
    {
        try {
            $account = $this->input('account');
            $nickname = $this->input('nickname');
            $password = $this->input('password');
            $password_repeat = $this->input('password_repeat');// TODO 改成统一校验类进行校验
            if (empty($account) || empty($nickname) || empty($password) || empty($password_repeat)) {
                print_r($account);
                print_r($nickname);
                print_r($password);
                print_r($password_repeat);
                die;
                Result::returnFailedResult('请填写有效的帐号/昵称');
            }
            if ($password !== $password_repeat) {
                Result::returnFailedResult("两次填写的密码不一致请重新填写");
            }
            $memberDao = new MemberDao();
            if (!empty($memberDao->getByAccount($account))) {
                Result::returnFailedResult("该手机号已被注册");
            }
            if (!empty($memberDao->getByNickName($nickname))) {
                Result::returnFailedResult("该昵称已存在");
            }
            $memberModel=new MemberModel();
            $memberModel->tel=$account;
            $memberModel->name=$nickname;
            $memberModel->password=$password;
            $memberModel->gmt_create=time();
            $memberModel->gmt_modified=time();
            $memberModel->sex=SELF::sex;
            $memberModel->head_icon=SELF::head_icon;
            if (!empty($row = $memberDao->insert($memberModel))) {
                $data = new \stdClass();
                $data->uid = $row[0]->id;
                $data->nickname = $row[0]->name;
                Result::returnSuccessResult($data, "注册已成功");
            } else {
                Result::returnFailedResult("注册账号失败");
            }
        } catch (\Exception $e) {
            Result::returnFailedResult("注册账号失败,系统级问题");
        }

    }

    public function test()
    {
//        $model = new MemberDao();
//        var_dump($model->getById(1));
//        exit;
        $this->registry();
    }
}
