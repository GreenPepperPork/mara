<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\mara\dao;

use app\mara\model\MemberModel;
use mara\library\Config;
use mara\library\orm\Dao;

class MemberDao extends Dao
{
    /**
     * 初始化Dao
     */
    function init()
    {
        $this->model = MemberModel::class;
        $this->table = 'bf_member';
        $this->master = $this->slave = Config::get('dida', 'database');
    }

    /**
     * @param integer $id
     * @return MemberModel[]
     * @throws \Exception
     */
    public function getById($id)
    {
        $row = $this->query()->where(['id' => 1])->get();

        return $row;
    }
}