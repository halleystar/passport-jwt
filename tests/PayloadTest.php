<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport\Test;

use Mockery;
use Meicai\JWTPassport\Payload;
use Meicai\JWTPassport\Claims\JwtId;
use Meicai\JWTPassport\Claims\Issuer;
use Meicai\JWTPassport\Claims\PassportId;
use Meicai\JWTPassport\Claims\IssuedAt;
use Meicai\JWTPassport\Claims\Expiration;

class PayloadTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $claims = [
            new PassportId(1),
            new Issuer('passport-api'),
            new Expiration(123 + 3600),
            new IssuedAt(123),
            new JwtId('foo'),
        ];

        $this->validator = Mockery::mock('Meicai\JWTPassport\Validators\PayloadValidator');

        $this->payload = new Payload($claims, $this->validator);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_throws_an_exception_when_trying_to_add_to_the_payload()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\PayloadException');

        $this->payload['foo'] = 'bar';
    }

    /** @test */
    public function it_throws_an_exception_when_trying_to_remove_a_key_from_the_payload()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\PayloadException');

        unset($this->payload['foo']);
    }

    /** @test */
    public function it_should_cast_the_payload_to_a_string_as_json()
    {
        $this->assertEquals((string) $this->payload, json_encode($this->payload->get()));
        $this->assertJsonStringEqualsJsonString((string) $this->payload, json_encode($this->payload->get()));
    }

    /** @test */
    public function it_should_allow_array_access_on_the_payload()
    {
        $this->assertTrue(isset($this->payload['iat']));
        $this->assertEquals($this->payload['sub'], 1);
        $this->assertArrayHasKey('exp', $this->payload);
    }

    /** @test */
    public function it_should_get_properties_of_payload_via_get_method()
    {
        $this->assertInternalType('array', $this->payload->get());
        $this->assertEquals($this->payload->get('sub'), 1);
    }

    /** @test */
    public function it_should_get_multiple_properties_when_passing_an_array_to_the_get_method()
    {
        $values = $this->payload->get(['sub', 'jti']);

        list($sub, $jti) = $values;

        $this->assertInternalType('array', $values);
        $this->assertEquals($sub, 1);
        $this->assertEquals($jti, 'foo');
    }

    /** @test */
    public function it_should_determine_whether_the_payload_has_a_claim()
    {
        $this->assertTrue($this->payload->has(new PassportId(1)));
    }

    /** @test */
    public function it_should_magically_get_a_property()
    {
        $sub = $this->payload->getPassportId();
        $jti = $this->payload->getJwtId();
        $iss = $this->payload->getIssuer();
        $this->assertEquals($sub, 1);
        $this->assertEquals($jti, 'foo');
        $this->assertEquals($iss, 'passport-api');
    }

    /** @test */
    public function it_should_throw_an_exception_when_magically_getting_a_property_that_does_not_exist()
    {
        $this->setExpectedException('\BadMethodCallException');

        $this->payload->getFoo();
    }

    /** @test */
    public function it_should_get_the_claims()
    {
        $claims = $this->payload->getClaims();

        $this->assertInstanceOf('Meicai\JWTPassport\Claims\Expiration', $claims[2]);
        $this->assertInstanceOf('Meicai\JWTPassport\Claims\JwtId', $claims[5]);
    }
}
