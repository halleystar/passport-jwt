<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */
namespace SPRUCE\JWTPassport\Test;

use Mockery;
use SPRUCE\JWTPassport\PayloadFactory;

use SPRUCE\JWTPassport\Claims\Factory;
use SPRUCE\JWTPassport;

class PayloadFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->claimFactory = new Factory();
        $this->validator = Mockery::mock('Meicai\JWTPassport\Validators\PayloadValidator');
        $this->factory = new PayloadFactory($this->claimFactory, $this->validator);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_should_return_a_payload_when_passing_an_array_of_claims_to_make_method()
    {
        $expTime = intval(\microtime(true)*1000) + 60;
    
        $payload = $this->factory->make(['passport_id' => 1, 'jti' => 'foo', 'iat' => 123]);

        $this->assertEquals($payload->get('passport_id'), 1);
        $this->assertEquals($payload->get('iat'), 123);
        $this->assertEquals($payload['exp'],  $expTime);

        $this->assertInstanceOf('Meicai\JWTPassport\Payload', $payload);
    }

    /** @test **/
    public function it_should_check_custom_claim_keys_accurately_and_accept_numeric_claims()
    {
        $payload = $this->factory->make([1 => 'claim one']);

        $this->assertEquals('claim one', $payload->get(1));
        $this->assertEquals(intval(\microtime(true)*1000), $payload->get('iat'));
    }

    /** @test */
    public function it_should_return_a_payload_when_chaining_claim_methods()
    {
        $payload = $this->factory->passport_id(1)->foo('baz')->make();

        $this->assertEquals($payload['passport_id'], 1);
        $this->assertEquals($payload->get('foo'), 'baz');

        $this->assertInstanceOf('Meicai\JWTPassport\Payload', $payload);
    }

    /** @test */
    public function should_return_a_payload_when_passing_claims()
    {
        $payload = $this->factory->passport_id(1)->foo(['bar' => [0, 0, 0]])->make();

        $this->assertEquals($payload->get('passport_id'), 1);
        $this->assertEquals($payload->get('foo'), ['bar' => [0, 0, 0]]);

        $this->assertInstanceOf('Meicai\JWTPassport\Payload', $payload);
    }

    /** @test */
    public function should_set_the_ttl()
    {
        $this->factory->setTTL(12345);

        $this->assertEquals($this->factory->getTTL(), 12345);
    }
}
