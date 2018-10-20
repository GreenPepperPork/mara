<?php

namespace mara\library\orm;

abstract class Model
{
    /**
     * 根据当前模型设置,判断当前SQL是否为存在主键查询
     *
     * @param array $sqlParams
     * @return bool|string|array
     */
    public function onlyPrimaryKey($sqlParams)
    {
        if (empty($sqlParams)) {
            return false;
        }

        $where  = $sqlParams['where'];
        $pkName = $this->getPkName();

        return isset($where[$pkName]) && count($sqlParams) == 1 ?
            is_array($where[$pkName]) ? $where[$pkName] : [$where[$pkName]] :
            false;
    }

    /**
     * 返回主键名称
     *
     * @return string
     */
    abstract public function getPkName();
}