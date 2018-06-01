<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport;

use Meicai\JWTPassport\Exceptions\JWTException;
use Meicai\JWTPassport\Providers\NamshiProvider;
use Meicai\JWTPassport\Claims\Factory;

class JWTManager
{

    var $jwt;

    var $payloadFactory;


    /**
     *  @param string $secret
     *  @param string $algo
     *  @param PayloadFactory  $payloadFactory
     */
    public function __construct(string $secret, string $algo)
    {
        $this->jwt = new NamshiProvider($secret, $algo);
        
        $this->payloadFactory = new PayloadFactory(new Factory());
    }

    /**
     * Encode Payload
     *
     * @param  Payload  $payload
     * @return Token
     */
    public function encode(Payload $payload)
    {
        $token = $this->jwt->encode($payload->get());

        return new Token($token);
    }

    /**
     * Decode Token
     *
     * @param  Token $token
     * @return Payload
     */
    public function decode(Token $token)
    {
        $payloadArray = $this->jwt->decode($token->get());

        $payload = $this->payloadFactory->make($payloadArray);

        return $payload;
    }

    /**
     * Refresh a Token.
     *
     * @param  Token  $token
     * @return Token
     */
    public function refresh(Token $token)
    {
        $payload = $this->decode($token);

        return $this->encode($this->payloadFactory->make(['sub' => $payload['sub'],'iat' => $payload['iat']]));
    }

    /**
     * Get the PayloadFactory.
     *
     * @return PayloadFactory
     */
    public function getPayloadFactory()
    {
        return $this->payloadFactory;
    }

    /**
     * Get the JWTProvider.
     *
     * @return JWTProvider
     */
    public function getJWTProvider()
    {
        return $this->jwt;
    }

}
