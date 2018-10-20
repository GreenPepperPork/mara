<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\mara\dao;

use app\mara\model\CommentModel;
use mara\library\Config;
use mara\library\orm\Dao;

class CommentDao extends Dao
{
    /**
     * 初始化Dao
     */
    function init()
    {
        $this->model = CommentModel::class;
        $this->table = 'bf_comment';
        $this->master = $this->slave = Config::get('dida', 'database');
    }

    function getById($id){
        $row=$this->query()->where(['id'=>id])->get();
        return $row;
    }
}
