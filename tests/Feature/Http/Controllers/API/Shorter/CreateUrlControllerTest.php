<?php

namespace Tests\Feature\Http\Controllers\API\Shorter;

use Tests\IntegrationTestCase;

class CreateUrlControllerTest extends IntegrationTestCase
{

    const ID = "93ada836-a8b6-11ed-afa1-0242ac120002";
    const URL = "https://www.yahoo.es";
    const SHORT_URL = "https://tinyurl.com/22qzfrlp";
    const VERSION = 2;


    /**
     * @return void
     */
    public function testCreate()
    {

        $response = $this
            ->withHeader("Authorization", "Bearer {}")
            ->json("post", "/api/url",
                [
                    "id" => self::ID,
                    "url" => self::URL
                ]
            );

        $response->assertStatus(200);

        $data = $response->json();

        $expected = [
            "url" => self::SHORT_URL
        ];

        $this->assertEquals($expected, $data);

    }

}
