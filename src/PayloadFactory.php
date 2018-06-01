<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */
namespace Meicai\JWTPassport;

use Meicai\JWTPassport\Claims\Factory;
use Ramsey\Uuid\Uuid;

class PayloadFactory
{
    /**
     * @var Factory
     */
    protected $claimFactory;

    /**
     * @var int unit second
     */
    protected $ttl = 60;

    /**
     * @var array
     */
    protected $defaultClaims = ['iss', 'iat', 'exp', 'jti'];

    /**
     * @var array
     */
    protected $claims = [];

    /**
     * @param Factory  $claimFactory
     */
    public function __construct(Factory $claimFactory)
    {
        $this->claimFactory = $claimFactory;
    }

    /**
     * Create the Payload instance.
     *
     * @param  array  $customClaims
     * @return Payload
     */
    public function make(array $customClaims = [])
    {
        $claims = $this->buildClaims($customClaims)->resolveClaims();

        return new Payload($claims);
    }

    /**
     * Add an array of claims to the Payload.
     *
     * @param  array  $claims
     * @return $this
     */
    public function addClaims(array $claims)
    {
        foreach ($claims as $name => $value) {
            $this->addClaim($name, $value);
        }

        return $this;
    }

    /**
     * Add a claim to the Payload.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @return $this
     */
    public function addClaim($name, $value)
    {
        $this->claims[$name] = $value;

        return $this;
    }

    /**
     * Build the default claims.
     *
     * @param  array  $customClaims
     * @return $this
     */
    protected function buildClaims(array $customClaims)
    {
        $this->addClaims($customClaims);

        foreach ($this->defaultClaims as $claim) {
            if (! array_key_exists($claim, $customClaims)) {              
                $this->addClaim($claim, $this->$claim());
            }
        }
        return $this;
    }

    /**
     * Build out the Claim.
     *
     * @return array
     */
    public function resolveClaims()
    {
        $resolved = [];
        foreach ($this->claims as $name => $value) {
            $resolved[] = $this->claimFactory->get($name, $value);
        }

        return $resolved;
    }

    /**
     * Set the Issuer (iss) claim.
     *
     * @return string
     */
    public function iss()
    {
        return 'passport-api';
    }

    /**
     * Set the Issued At (iat) claim.
     *
     * @return numeric
     */
    public function iat()
    {
        return intval(\microtime(true)*1000);
    }

    /**
     * Set the Expiration (exp) claim.
     *
     * @return numeric
     */
    public function exp()
    {
        return intval(\microtime(true)*1000) + $this->ttl;
    }
     
    /**
     * Set a uuid (jti) for the token.
     *
     * @return string
     */
    protected function jti()
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * Set the token ttl (in minutes).
     *
     * @param  int  $ttl
     * @return $this
     */
    public function setTTL($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Get the token ttl.
     *
     * @return int
     */
    public function getTTL()
    {
        return $this->ttl;
    }

    /**
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return PayloadFactory
     */
    public function __call($method, $parameters)
    {
        $this->addClaim($method, $parameters[0]);

        return $this;
    }
}
