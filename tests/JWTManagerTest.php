<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace Meicai\JWTPassport\Test;

use Mockery;
use Meicai\JWTPassport\Token;
use Meicai\JWTPassport\Payload;
use Meicai\JWTPassport\JWTManager;
use Meicai\JWTPassport\Claims\JwtId;
use Meicai\JWTPassport\Claims\Issuer;
use Meicai\JWTPassport\Claims\PassportId;
use Meicai\JWTPassport\Claims\IssuedAt;
use Meicai\JWTPassport\Claims\Expiration;

class JWTManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = new JWTManager("asdasdasd", "HS256");

        $this->validator = Mockery::mock('Meicai\JWTPassport\Validators\PayloadValidator');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function should_encode_payload()
    {
        $claims = [
            new PassportId(1),
            new Issuer('passport-api'),
            new Expiration(123 + 3600),
            new IssuedAt(123),
            new JwtId('jwt_id'),
        ];
        $payload = new Payload($claims, $this->validator);

        $token = $this->manager->encode($payload);

        $this->assertEquals($token, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9leGFtcGxlLmNvbSIsImV4cCI6MzcyMywibmJmIjoxMjMsImlhdCI6MTIzLCJqdGkiOiJmb28ifQ.4X3SgCGGVpXaUFVqPyXwRGkzt3PzwSEdZsh6BOLU3_M');
        
        return $token;
    }

    /** 
     *  @test
     *  @depends should_encode_payload
    */
    public function should_decode_token($token)
    {
        $payload = $this->manager->decode($token);
        $decodeClaims = $payload->toArray();
        $claims = [
            "passport_id" => 1,
            "iss" => "passport-api",
            "exp" => "3723",
            "iat" => "123",
            "jti" => "jwt_id"        
        ];
        $this->assertEquals($decodeClaims, $claims);
    }

    /** @test */
    public function should_refresh_token()
    {

        $token = $this->manager->refresh($token);

        $this->assertInstanceOf('Meicai\JWTPassport\Token', $token);
    }

    /** @test */
    public function should_invalidate_token()
    {
        $claims = [
            new PassportId(1),
            new Issuer('passport-api'),
            new Expiration(123 + 3600),
            new IssuedAt(123),
            new JwtId('jwt_id'),
        ];
        $this->manager->invalidate($token);
    }
}
