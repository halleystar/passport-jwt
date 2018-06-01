<?php

namespace Meicai\JWTPassport\Test\Providers;

use Mockery;
use Meicai\JWTPassport\Providers\NamshiProvider;

class NamshiProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->jws = Mockery::mock('Namshi\JOSE\JWS');
        $this->provider = new NamshiProvider('secret', 'HS256', $this->jws);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_should_return_the_token_when_passing_a_valid_passport_id_to_encode()
    {
        $payload = ['passport_id' => 1, 'exp' => 123, 'iat' => 123, 'iss' => 'passport-api'];


        $token = $this->provider->encode($payload);

        $this->assertEquals('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXNzcG9ydF9pZCI6MSwiZXhwIjoxMjMsImlhdCI6MTIzLCJpc3MiOiIvZm9vIn0.Y3CYPlmokV0Q7J528ZWRzKGnAcBtgkj0nDV1q7zjlEU', $token);
    }

    /** @test */
    public function it_should_throw_an_invalid_exception_when_the_payload_could_not_be_encoded()
    {
        //TODO
    }

    /** @test */
    public function it_should_throw_a_token_invalid_exception()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\TokenInvalidException');

        $this->jws->shouldReceive('verify')->andReturn(false);

        $token = $this->provider->decode('decode');
    }
}
