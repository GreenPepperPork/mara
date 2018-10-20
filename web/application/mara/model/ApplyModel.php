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

class ApplyModel extends Model
{
    /**
     * 图书所有者ID
     *
     * @var int
     */
    public $owner_uid;

    /**
     * 图书ID
     *
     * @var int
     */
    public $book_id;

    /**
     * 申请者uid
     *
     * @var int
     */
    public $apply_uid;

    /**
     * 是否已读 0 未读 | 1 已读
     *
     * @var string
     */
    public $is_read;

    public $gmt_create;

    public $gmt_modified;
}