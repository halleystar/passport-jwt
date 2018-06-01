<?php

namespace Meicai\JWTPassport\Test;
use  Meicai\JWTPassport\Validators\PayloadValidator;

class PayloadValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->validator = new PayloadValidator();
    }

    /** @test */
    public function it_should_return_true_when_providing_a_valid_payload()
    {
        $payload = [
            'iss' => 'passport-api',
            'iat' => 100,
            'exp' => 100 + 3600,
            'passport_id' => 1,
            'jti' => 'foo',
        ];

        $this->assertTrue($this->validator->isValid($payload));
    }

    /** @test */
    public function it_should_throw_an_exception_when_providing_an_invalid_iat_claim()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\TokenInvalidException');

        $payload = [
            'iss' => 'passport-api',
            'iat' => 150,
            'exp' => 150 + 3600,
            'passport_id' => 1,
            'jti' => '123123213',
        ];

        $this->validator->check($payload);
    }

    /** @test */
    public function it_should_throw_an_exception()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\TokenInvalidException');

        $payload = [
            'iss' => 'passport-api',
            'passport_id' => 1,
        ];

        $this->validator->check($payload);
    }

    /** @test */
    public function it_should_throw_an_exception_because_invalid_exp()
    {
        $this->setExpectedException('Meicai\JWTPassport\Exceptions\TokenInvalidException');

        $payload = [
            'iss' => 'passport-api',
            'iat' => 100,
            'exp' => 'asdasdasd',
            'passport_id' => 1,
            'jti' => 'asdasdasdasd',
        ];

        $this->validator->check($payload);
    }
}
