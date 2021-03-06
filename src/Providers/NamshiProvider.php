<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */
namespace SPRUCE\JWTPassport\Providers;

use Exception;
use SPRUCE\JOSE\JWS;
use SPRUCE\JWTPassport\Exceptions\JWTException;
use SPRUCE\JWTPassport\Exceptions\TokenInvalidException;

class NamshiProvider extends JWTProvider
{
    /**
     * @var \Namshi\JOSE\JWS
     */
    protected $jws;

    /**
     * @param string  $secret
     * @param string  $algo
     */
    public function __construct($secret, $algo)
    {
        parent::__construct($secret, $algo);

        $this->jws = new JWS(['typ' => 'JWT', 'alg' => $algo]);
    }

    /**
     * Create a JSON Web Token.
     *
     * @return string
     * @throws JWTException
     */
    public function encode(array $payload)
    {
        try {
            $this->jws->setPayload($payload)->sign($this->secret);

            return $this->jws->getTokenString();
        } catch (Exception $e) {
            throw new JWTException('Could not create token: '.$e->getMessage());
        }
    }

    /**
     * Decode a JSON Web Token.
     *
     * @param  string  $token
     * @return array
     * @throws JWTException
     */
    public function decode($token)
    {
        try {
            $jws = JWS::load($token);
        } catch (Exception $e) {
            throw new TokenInvalidException('Could not decode token: '.$e->getMessage());
        }

        if (! $jws->verify($this->secret, $this->algo)) {
            throw new TokenInvalidException('Token Signature could not be verified.');
        }

        return $jws->getPayload();
    }
}
