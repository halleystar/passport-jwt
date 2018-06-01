<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport\Validators;

interface ValidatorInterface
{

    /**
     * check
     */
    public function check($value);
}
