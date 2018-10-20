<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace app\common\assembly;

class Result
{
    const CODE_SUCCESS = 0;
    const CODE_FAILED  = -1;

    /**
     * @var int 0|成功,其他失败
     */
    public $code;

    /**
     * @var string
     */
    public $message;

    /**
     * @var mixed
     */
    public $data;

    public function __construct($code, $data, $message)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @param null $data
     * @param string $message
     */
    public static function returnSuccessResult($data = null, $message = '')
    {
        echo self::buildSuccessResult($data, $message);
        exit;
    }

    /**
     * @param int $code
     * @param null $data
     * @param string $message
     */
    public static function returnFailedResult($message, $code = self::CODE_FAILED, $data = null)
    {
        echo self::buildFailedResult($code, $data, $message);
        exit;
    }

    public static function buildSuccessResult($data = null, $message = '')
    {
        return new self(self::CODE_SUCCESS, $data, $message);
    }

    public static function buildFailedResult($code, $data = null, $message = '')
    {
        return new self($code, $data, $message);
    }

    public function success()
    {
        return $this->code === self::CODE_SUCCESS;
    }

    public function __toString()
    {
        header("content-type:application/json;charset=utf8");
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}