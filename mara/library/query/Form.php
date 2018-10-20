<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace mara\library\query;

class Form
{
    public static function check($value, $rule, $message = null)
    {
        if (is_string($rule) && is_callable(self::$rule)) {
            self::$rule($value, $message);
        }
    }

    public static function parseRule()
    {
        // TODO
    }

}
