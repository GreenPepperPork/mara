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
        $row = $this->query()->where(['id' => $id])->getOne();

        return $row;
    }

    /**
     * @param $MemberModel
     * @return bool|int
     * @throws \Exception
     */
    public function insert($memberModel){
        $row=$this->query()->insert($memberModel);

        return $row;
    }

    public function getByAccountAndPassword($tel,$password){
        $row=$this->query()->where(['tel'=>$tel,'password'=>$password])->get();

        return $row;
    }

    public function getByAccount($account){
        $row=$this->query()->where(['tel'=>$account])->get();

        return $row;
    }

    public function getByNickName($nickName){
        $row=$this->query()->where(['name'=>$nickName])->get();

        return $row;
    }

    public function getByIds($idArray){
        $row=$this->query()->where(['id'=>$idArray])->get();

        return $row;
    }

    public function update($updateArr,$id){
        $row = $this->query()->where(['id' => $id])->update($updateArr);

        return $row;
    }

}
