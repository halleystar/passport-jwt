<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport\Exceptions;

class PayloadException extends JWTException
{
    /**
     * @var int
     */
    protected $statusCode = 500;
}
