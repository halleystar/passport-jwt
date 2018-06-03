<?php


/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace SPRUCE\JWTPassport\Claims;

class Factory
{
    /**
     * @var array
     */
    private static $classMap = [
        'exp' => 'Meicai\JWTPassport\Claims\Expiration',
        'iat' => 'Meicai\JWTPassport\Claims\IssuedAt',
        'iss' => 'Meicai\JWTPassport\Claims\Issuer',
        'jti' => 'Meicai\JWTPassport\Claims\JwtId',
        'sub' => 'Meicai\JWTPassport\Claims\PassportId',
    ];

    /**
     * Get the instance of the claim when passing the name and value.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @return Claim
     */
    public function get($name, $value)
    {
        if ($this->has($name)) {
            return new self::$classMap[$name]($value);
        }

        return new Custom($name, $value);
    }


    /**
     * Check whether the claim exists.
     *
     * @param  string  $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, self::$classMap);
    }
}
