<?php

namespace Tests\Integration\BoundedContext\Backoffice\Shorter\Infra\Repository\Http;

use App\BoundedContext\Backoffice\Shorter\Infra\Repository\Http\ShorterShortUrlHttpRepository;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use Tests\IntegrationTestCase;

class ShorterShortUrlHttpRepositoryTest extends IntegrationTestCase
{

    const URL = "https://yahoo.es";
    const SHORT_URL = "https://tinyurl.com/2a2pw3fb";

    public function testFindByUrl() {

        $repository = new ShorterShortUrlHttpRepository();
        $response = $repository->findByUrl(new ShorterUrlValueObject(self::URL));

        $this->assertEquals(self::SHORT_URL, $response->getShortUrl()->getString());

    }
}
