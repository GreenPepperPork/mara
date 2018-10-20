<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\mara\model;

use mara\library\orm\Model;

class MemberModel extends Model
{
    /**
     * 用户昵称
     *
     * @var string
     */
    public $name;

    /**
     * 手机电话
     *
     * @var string
     */
    public $tel;

    /**
     * 头像
     *
     * @var string
     */
    public $head_icon;

    /**
     * 性别 用户性别 1-男生 2-女生
     *
     * @var int
     */
    public $sex;

    public $gmt_create;

    public $gmt_modified;
}
