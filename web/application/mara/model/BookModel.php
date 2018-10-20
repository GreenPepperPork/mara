<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\mara\model;

use app\mara\controller\BookStatusEnum;
use mara\library\orm\Model;

class BookModel extends Model
{
    /**
     * 书本名称
     *
     * @var string
     */
    public $name;

    /**
     * 书本简介
     *
     * @var string
     */
    public $brief;

    /**
     * 读后感
     *
     * @var string
     */
    public $reaction;

    /**
     * 封面
     *
     * @var string
     */
    public $cover;

    /**
     * 其他照片
     *
     * @var
     */
    public $images;

    /**
     *
     * @var BookStatusEnum::STATUS_IDEA | BookStatusEnum::STATUS_RENTING
     */
    public $status;

    /**
     * 拥有者ID
     *
     * @var int
     */
    public $owner_uid;

    /**
     * 租借用户ID
     *
     * @var int
     */
    public $rent_uid;

    /**
     * 是否可出借 0-不可 1-可出借
     *
     * @var int
     */
    public $is_rent;

    public $gmt_create;

    public $gmt_modified;
}