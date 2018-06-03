<?php

/*
 *
 * @author maqiang01@meicai.cn
 *
 */

namespace SPRUCE\JWTPassport\Test;

use SPRUCE\JWTPassport\Claims\Expiration;
use SPRUCE\JWTPassport\Claims\IssuedAt;
use SPRUCE\JWTPassport\Claims\Issuer;
use SPRUCE\JWTPassport\Claims\JwtId;
use SPRUCE\JWTPassport\Claims\PassportId;
use SPRUCE\JWTPassport\JWTManager;
use SPRUCE\JWTPassport\Payload;
use Mockery;

class JWTManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->privateRsaKey = 
<<<pri
-----BEGIN PRIVATE KEY-----
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
/9SZZcZtZmfdw9sz9K9/7tzeSqELFA2o
-----END PRIVATE KEY-----
pri;
        $this->manager = new JWTManager($this->privateRsaKey, "RS256");
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function should_encode_payload_and_decode_when_use_public_key()
    {
        $claims = [
            new PassportId(1),
            new Issuer('passport-api')
        ];
        $payload = new Payload($claims);

        $token = $this->manager->encode($payload);

        $this->assertEquals($token, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJwYXNzcG9ydF9pZCI6MSwiaXNzIjoicGFzc3BvcnQtYXBpIn0.fOA1qu4k6ZPuealE4qcyvQ99U7raqUJ9XE0ih6TsAUqG6-SEl4W0qZ2fVr5XnN9OT0ie6gCf50yNHy0mwZ6DecxSL4z6Q-Ya5vY2agtkF8CulMwSyOehKa1dnRPKvqtDcqd3O_hUP13uUKG2woeEhDeCxMZ565TdnqMLyvtoJsf6YgwXfhQirBZAmbofJJYwKAQLhS8XmRm-YdtNjp7wICVSRsmEEDjRjjrMYo0E69pJO1no1Nh84P2aooExw12_8y991y1VyrNx6uIykBx5oDaFNXDH2NIiSHRoIxIXceyjv-4bzCfBzDmG8vseZ9ooZcb1kaxgzwxQUWNzPjkkUKWco54CTjJ7x7dYIb1UF9mNZv4eN1o0oP9TJ_dhL43ix0slFXFLdi5qBvR1CIjnOzM5gGJCQZ-W0bRNOTaKTo5kwuJEYALstLCYy1heV20wGJgMfXUVl81UMqfR6GvjdWBW-_UMmyqH4gfTb_P5XdeYnXpWiLeSWpzq3nFincn9K4UUcpn0CtppmqmEcXvGAUZg_diMXk5_U22Vqmlv0uk-4uje2UAvnBT9falzy2qmV49zEELMHBzGHDupb1HUZCNXFe6Dmj_9TIIxbXkCVfPOUxcdroUBsPbqAFwRCXXjBto7oZUGAPxvlB3UO5NZjKEc6P7YB49rPZ7UCmaHvk0');

        return $token;
    }

    /** 
     *  @test 
     *  @depends should_encode_payload_and_decode_when_use_public_key
    */
    public function should_encode_payload($token)
    {
        $new_key_pair = openssl_get_privatekey($this->privateRsaKey);
        
        $details = openssl_pkey_get_details($new_key_pair);
        $public_key_pem = $details['key'];

        $manager = new JWTManager($public_key_pem, "RS256");
        $payload = $manager->decode($token);
        $this->assertEquals($payload->get('passport_id'), 1);
        $this->assertEquals($payload->get('iss'), 'passport-api');

        return $token;
    }

    /**
     *  @test
     *  @depends should_encode_payload
     */
    public function should_refresh_token($token)
    {

        $token = $this->manager->refresh($token);

        $this->assertInstanceOf('Meicai\JWTPassport\Token', $token);
    }
}
