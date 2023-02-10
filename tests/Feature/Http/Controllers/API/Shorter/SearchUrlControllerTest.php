<?php

namespace Tests\Feature\Http\Controllers\API\Shorter;

use Illuminate\Support\Facades\DB;
use Tests\IntegrationTestCase;

class SearchUrlControllerTest extends IntegrationTestCase
{

    const ID = "c72dc634-a94a-11ed-afa1-0242ac120002";
    const URL = "https://www.yahoo.com";
    const SHORT_URL = "https://www.short.com?a=1";
    const VERSION = 1;

    const OFFSET = 0;
    const LIMIT = 50;
    const TOTAL_URLS = 1;

    public function setUp(): void
    {
        parent::setUp();

        $urls = [
            [
                "id" => self::ID,
                "url" => self::URL,
                "short_url" => self::SHORT_URL,
                "version" => self::VERSION,
            ],

        ];

        DB::table("shorter_url")->insert($urls);

    }

    public function testSearch() {

        $response = $this
            ->withHeader("Authorization", "Bearer {}")
            ->get("/api/url");

        $response->assertStatus(200);
        $response->assertJson([
            "data" => [[
                "id" => self::ID,
                "url" => self::URL,
                "shortUrl" => self::SHORT_URL,
                "version" => self::VERSION,
            ]],
            "offset" => self::OFFSET,
            "limit" => self::LIMIT,
            "total" => self::TOTAL_URLS
        ]);

    }

}
