<?php

namespace App\BoundedContext\Core\Model\Exceptions;

class EntityNotFound extends \Exception
{

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $id;

    /**
     * @param string $entity
     * @param string $id
     */
    public function __construct(string $entity, string $id)
    {
        parent::__construct("Not found entity \"" . $entity . "\" with id \"" . $id . "\"", 0, null);
        $this->entity = $entity;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


}
