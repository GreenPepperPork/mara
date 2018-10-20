<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\mara\dao;

use app\mara\model\ReactionModel;
use mara\library\Config;
use mara\library\orm\Dao;

class ReactionDao extends Dao
{
    /**
     * 初始化Dao
     */
    function init()
    {
        $this->model = ReactionModel::class;
        $this->table = 'bf_reaction';
        $this->master = $this->slave = Config::get('dida', 'database');
    }

    /**
     * @param integer $uid
     * @return ReactionModel[]
     * @throws \Exception
     */
    public function listByUid($uid, $offset = 0, $limit = 20)
    {
        $list = $this->query()->where(['uid' => $uid])->get($limit, $offset);

        return $list;
    }

    /**
     * @param integer $id
     * @return ReactionModel
     * @throws \Exception
     */
    public function listById($id)
    {
        $row = $this->query()->where(['id' => $id])->getOne();

        return $row;
    }

    /**
     * @param $reactionDao
     * @return bool|int
     * @throws \Exception
     */
    public function insert($reactionModel)
    {
        $row = $this->query()->insert($reactionModel);

        return $row;
    }

    /**
     * @param $id
     * @param $content
     * @return int
     * @throws \Exception
     */
    public function update($updateArr,$id)
    {
        $row = $this->query()->where(['id' => $id])->update($updateArr);

        return $row;
    }

}
