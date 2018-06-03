<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport;

use SPRUCE\JWTPassport\Validators\TokenValidator;

class Token
{
    /**
     * @var string
     */
    private $value;

    /**
     * Create a new JSON Web Token.
     *
     * @param string  $value
     */
    public function __construct($value)
    {
        $tokenValidator = new TokenValidator();
        $tokenValidator->check($value);

        $this->value = $value;
    }

    /**
     * Get the token.
     *
     * @return string
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Get the token when casting to string.
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->value);
    }
}
