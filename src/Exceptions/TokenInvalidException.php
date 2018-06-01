<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport\Exceptions;

class TokenInvalidException extends JWTException
{
    /**
     * @var int
     */
    protected $statusCode = 400;
}
