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
     * @var int
     */
    public $book_id;

    /**
     * @var int
     */
    public $uid;

    /**
     * 评论/读后感内容
     *
     * @var int
     */
    public $comment;

    /**
     * @var CommentTypeEnum::TYPE_COMMENT | CommentTypeEnum::TYPE_REACTION
     */
    public $type;

    public $gmt_create;

    public $gmt_modified;
}