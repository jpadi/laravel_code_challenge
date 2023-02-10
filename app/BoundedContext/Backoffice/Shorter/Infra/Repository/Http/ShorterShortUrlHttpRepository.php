<?php

namespace App\BoundedContext\Backoffice\Shorter\Infra\Repository\Http;

use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterShortUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterShortUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use GuzzleHttp\Client;

class ShorterShortUrlHttpRepository implements ShorterShortUrlRepository
{

    public function findByUrl(ShorterUrlValueObject $url): ShorterShortUrl
    {

        $client = new Client();

        $res = $client->request('GET', 'https://tinyurl.com/api-create.php', [
            "query"=>[
                "url"=>$url->getString()
            ]]
        );

        if ($res->getStatusCode() != 200) { // 200 OK
            throw new \Exception("error with tiniurl");
        }

        return new ShorterShortUrl(
            new ShorterShortUrlValueObject($res->getBody()->getContents())
        );
    }
}
