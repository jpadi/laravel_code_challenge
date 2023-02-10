<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Response;

use App\BoundedContext\Core\Model\Responses\ListItemResponse;

class SearchShorterUrlItemResponse extends ListItemResponse
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $shortUrl;

    /**
     * @var int
     */
    private $version;

    /**
     * @param string $id
     * @param string $url
     * @param string $shortUrl
     * @param int $version
     */
    public function __construct(string $id, string $url, string $shortUrl, int $version)
    {
        $this->id = $id;
        $this->url = $url;
        $this->shortUrl = $shortUrl;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "url" => $this->url,
            "shortUrl"=>$this->shortUrl,
            "version" => $this->version
        ];
    }
}
