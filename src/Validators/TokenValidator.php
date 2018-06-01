<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport\Validators;

use Meicai\JWTPassport\Exceptions\TokenInvalidException;

class TokenValidator implements ValidatorInterface
{
    /**
     * Check Correctness of the token.
     *
     * @param string  $value
     * @return void
     */
    public function check($value)
    {
        $this->validateStructure($value);
    }

    /**
     * @param  string  $token
     * @return bool
     */
    protected function validateStructure($token)
    {
        if (count(explode('.', $token)) !== 3) {
            throw new TokenInvalidException('invalid token');
        }

        return true;
    }
}
