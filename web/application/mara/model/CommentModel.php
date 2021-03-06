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
use app\mara\controller\CommentTypeEnum;
use mara\library\orm\Model;

class CommentModel extends Model
{
    /**
     * 读后感ID
     *
     * @var int
     */
    public $reaction_id;

    /**
     * @var int
     */
    public $uid;

    /**
     * 评论内容
     *
     * @var int
     */
    public $content;

    public $gmt_create;

    public $gmt_modified;
}