<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace app\index\model;

use mara\library\Cache;
use mara\library\Config;
use mara\library\orm\Builder;
use mara\library\orm\Query;

class MemberModel
{
    public function getById()
    {
//        $query = new Query(new Builder(Config::get('dida', 'database')), [
//            'table' => 'member'
//        ]);

        // 从快速缓存中获取文章列表
//        $fastCache = Config::get('fast_cache', 'storage');
//        $list = Cache::stored($fastCache['drive'])->get($fastCache['filename']);

//        return $list;
    }
}