<?php


/*
 *
 * @author maqiang01@meicai.cn
 *
 */
namespace SPRUCE\JWTPassport\Claims;

interface ClaimInterface
{
    /**
     * Set claim value
     *
     */
    public function setValue($value);

    /**
     * Get claim value.
     */
    public function getValue();

    /**
     * Set claim name.
     */
    public function setName($name);

    /**
     * Get the claim name.
     */
    public function getName();
}
