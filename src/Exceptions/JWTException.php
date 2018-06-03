<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */
namespace SPRUCE\JWTPassport\Exceptions;

class JWTException extends \Exception
{
    /**
     * @var int default code for jwt
     */
    protected $statusCode = 500;

    public function __construct($message, $statusCode = null)
    {
        parent::__construct($message);

        if (!empty($statusCode)) {
            $this->setStatusCode($statusCode);
        }
    }

    public function setStatusCode($statusCode):void
    {
        $this->statusCode = $statusCode;
    }


    public function getStatusCode():int
    {
        return $this->statusCode;
    }
}
