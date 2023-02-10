<?php

namespace App\BoundedContext\Core\Model\Responses;

class ErrorResponse
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $error;

    /**
     * @param string $id
     * @param string $error
     */
    public function __construct(string $id, string $error)
    {
        $this->id = $id;
        $this->error = $error;
    }

    /**
     * @param string $id
     * @param string $error
     * @return array
     */
    public static function create(string $id, string $error): array
    {
        return (new ErrorResponse($id, $error))->toArray();
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
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "message" => $this->error
        ];
    }


}
