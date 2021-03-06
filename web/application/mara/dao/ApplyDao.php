<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\mara\dao;

use app\mara\model\ApplyModel;
use mara\library\Config;
use mara\library\orm\Dao;

class ApplyDao extends Dao
{
    /**
     * 初始化Dao
     */
    function init()
    {
        $this->model = ApplyModel::class;
        $this->table = 'bf_apply';
        $this->master = $this->slave = Config::get('dida', 'database');
    }

    /**
     * @param $uid
     * @return ApplyModel[]
     * @throws \Exception
     */
    public function listByOwnerUid($uid)
    {
        $where['owner_uid'] = $uid;

        $list = $this->query()
            ->where($where)
            ->orderBy(['id' => 'desc'])
            ->get(50);

        return $list;
    }

    /**
     * @param $uid
     * @return ApplyModel[]
     * @throws \Exception
     */
    public function listByApplyUid($uid)
    {
        $where['apply_uid'] = $uid;

        $list = $this->query()
            ->where($where)
            ->orderBy(['id' => 'desc'])
            ->get(50);

        return $list;
    }

    /**
     * @param $uid
     * @return ApplyModel[]
     * @throws \Exception
     */
    public function listAllApplyUid($uid)
    {
        $sql = 'SELECT * FROM bf_apply WHERE owner_uid = ? OR apply_uid = ? ORDER BY id';
        $list = $this->query()->getBuilder()->state($sql, [$uid, $uid])->getAll();

        return $list;
    }

    public function insert($applyModel){
        $row=$this->query()->insert($applyModel);

        return $row;
    }
}
