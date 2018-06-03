<?php


/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace SPRUCE\JWTPassport\Claims;

class Custom extends Claim
{
    /**
     * @param string  $name
     * @param mixed   $value
     */
    public function __construct($name, $value)
    {
        parent::__construct($value);
        $this->setName($name);
    }
}
