<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */
namespace Meicai\JWTPassport\Providers;

abstract class JWTProvider
{
    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $algo;

    /**
     * @param string  $secret
     * @param string  $algo
     */
    public function __construct($secret, $algo = 'HS256')
    {
        $this->secret = $secret;
        $this->algo = $algo;
    }

    /**
     * Set the algorithm.
     *
     * @param  string  $algo
     * @return self
     */
    public function setAlgo($algo)
    {
        $this->algo = $algo;

        return $this;
    }

    /**
     * Get the algorithm.
     *
     * @return string
     */
    public function getAlgo()
    {
        return $this->algo;
    }

    /**
     * Set the secret.
     *
     * @param  string  $secret
     *
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get the secret.
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param  array  $payload
     * @return string
     */
    public function encode(array $payload) 
    {
        //sub class to implement
    }

    /**
     * @param  string  $token
     * @return array
     */
    public function decode($token)
    {
        //sub class to implement
    }
}
