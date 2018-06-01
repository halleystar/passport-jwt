<?php

namespace Meicai\JWTPassport\Test\Providers;

use Mockery;
use Meicai\JWTPassport\Providers\NamshiAdapter;

class NamshiAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->jws = Mockery::mock('Namshi\JOSE\JWS');
        $this->provider = new NamshiAdapter('secret', 'HS256', $this->jws);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_should_return_the_token_when_passing_a_valid_passport_id_to_encode()
    {
        $payload = ['passport_id' => 1, 'exp' => 123, 'iat' => 123, 'iss' => '/foo'];

        $this->jws->shouldReceive('setPayload')->once()->with($payload)->andReturn(Mockery::self());
        $this->jws->shouldReceive('sign')->once()->with('secret')->andReturn(Mockery::self());
        $this->jws->shouldReceive('getTokenString')->once()->andReturn('foo.bar.baz');

        $token = $this->provider->encode($payload);

        $this->assertEquals('foo.bar.baz', $token);
    }

    /** @test */
    public function it_should_throw_an_invalid_exception_when_the_payload_could_not_be_encoded()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\JWTException');

        $this->jws->shouldReceive('sign')->andThrow(new \Exception);

        $payload = ['sub' => 1, 'exp' => 123, 'iat' => 123, 'iss' => 'passport-api'];
        $this->provider->encode($payload);
    }

    /** @test */
    public function it_should_throw_a_token_invalid_exception()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\TokenInvalidException');

        $this->jws->shouldReceive('verify')->andReturn(false);

        $token = $this->provider->decode('decode');
    }
}
