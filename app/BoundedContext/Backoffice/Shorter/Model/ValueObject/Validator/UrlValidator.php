<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\ValueObject\Validator;

trait UrlValidator
{

    public function validateUrl(string $url): bool {
        $parsedUrl = parse_url($url);
        // have scheme and host
        if (!isset($parsedUrl["scheme"]) || !isset($parsedUrl["host"]) || count(explode(".", $parsedUrl["host"])) < 2) {
            return false;
        }
        return true;
    }

}
