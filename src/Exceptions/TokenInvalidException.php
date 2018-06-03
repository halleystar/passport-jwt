<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace SPRUCE\JWTPassport\Exceptions;

class TokenInvalidException extends JWTException
{
    /**
     * @var int
     */
    protected $statusCode = 400;
}
