<?php


/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace SPRUCE\JWTPassport\Claims;

class JwtId extends Claim
{
    /** 
     * uuid
     * @var string
     */
    protected $name = 'jti';
}
