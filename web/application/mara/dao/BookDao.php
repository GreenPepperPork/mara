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
use mara\library\orm\symbol\Like;

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
     * @param $key
     * @return BookModel[]
     * @throws \Exception
     */
    public function listBook($page, $limit, $key)
    {
        $offset = ($page - 1) * $limit;

        $query = $this->query();
        if (!empty($key)) {
            $query->where(['name' => new Like('%' . $key . '%')]);
        }

        $list = $query->orderBy(['id' => 'desc'])->get($limit, $offset);

        return $list;
    }

    public function insert($bookModel)
    {
        $row=$this->query()->insert($bookModel);

        return $row;
    }

    public function update($updateArr, $id)
    {
        $row = $this->query()->where(['id' => $id])->update($updateArr);

        return $row;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getById($id)
    {
        $row = $this->query()->where(['id' => $id])->getOne();

        return $row;
    }

}
