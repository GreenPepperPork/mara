<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\mara\dao;

use app\mara\model\BookModel;
use mara\library\Config;
use mara\library\orm\Dao;

class BookDao extends Dao
{
    /**
     * 初始化Dao
     */
    function init()
    {
        $this->model = BookModel::class;
        $this->table = 'bf_book';
        $this->master = $this->slave = Config::get('dida', 'database');
    }

    /**
     * @param $page
     * @param $limit
     * @return BookModel[]
     * @throws \Exception
     */
    public function listBook($page, $limit)
    {
        $offset = ($page - 1) * $limit;

        $list = $this->query()->orderBy(['id' => 'desc'])->get($limit, $offset);

        return $list;
    }
}