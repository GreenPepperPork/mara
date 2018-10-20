<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------
namespace mara\library\view;

use mara\library\Componet;

class View
{
    protected $data = [];

    private static $calledClass;

    public function assign($name, $value = '')
    {
        $this->data[$name] = $value;
    }

    public function fetch()
    {
    }

    public function display()
    {
    }

    public function get($name = '')
    {
        return $name ? $this->data[$name] : $this->data;
    }

    public function render($path, $config = [])
    {
        Componet::render($path, $config);
    }

    public function layout()
    {
        return '';
    }

    public function getCalledInfo()
    {
        $class = get_called_class();
        if (!isset(self::$calledClass[$class])) {
            $reflect = new \ReflectionClass($class);
            self::$calledClass[$class] = [
                '__CALL__'       => $reflect->getFileName(),
                '__CALL_DIR__'   => dirname($reflect->getFileName()),
                '__CONTROLLER__' => str_ireplace(CONTROLLER_LAYER, '', $reflect->getShortName()),
                '__NAMESPACE__'  => $reflect->getNamespaceName()
            ];
        }

        return self::$calledClass[$class];
    }

    public function import(array $value, $range = '')
    {
        if ($range) {
            $this->data[$range] = array_merge(isset($this->data[$range]) ? $this->data[$range] : [], $value);
        } else {
            $this->data = array_merge(is_array($this->data) ? $this->data : [], $value);
        }
    }

    function __get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }
}
