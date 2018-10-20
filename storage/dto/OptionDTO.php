<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace storage\dto;

/**
 * 选项DTO
 */
class OptionDTO
{
    /**
     * @var int 编号
     */
    public $order;

    /**
     * @var string 选项文本
     */
    public $option_content;

    /**
     * @see QuestionDTO::$number
     * @var string 下一个题目编号,如果为0则表示out
     */
    public $next;

    /**
     * @var string 结果content
     */
    public $result_content;

    /**
     * @var string 图片地址
     */
    public $img;
}
