<?php

namespace App\BoundedContext\Core\Model\EventBus;

use App\BoundedContext\Core\Model\Exceptions\EventAttributeNotFound;

abstract class Event
{
    /**
     * Id of the aggregate
     * @var string
     */
    protected $id;

    /**
     * event id
     * @var string
     */
    protected $eventId;

    /**
     * @var \DateTime
     */
    protected $eventCreatedAt;

    /**
     * @var array
     */
    private $eventAttributes = [];

    /**
     * @param string $eventId
     * @param array $eventAttributes
     * @throws EventAttributeNotFound
     */
    public function __construct(string $id, string $eventId, array $eventAttributes)
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->eventCreatedAt = new \DateTime();

        foreach ($eventAttributes as $attribute) {
            $method = $this->getGetter($attribute);
            if (!method_exists($this, $method)) {
                throw new EventAttributeNotFound(
                    "attribute \"" . $attribute . "\" not found for event. Is necesary a public method with the name . $method"
                );
            }
        }

        $this->eventAttributes = $eventAttributes;
    }

    private function getGetter($attribute): string
    {
        return "get" . ucfirst($attribute);
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
    public function getEventId(): string
    {
        return $this->eventId;
    }

    /**
     * @return \DateTime
     */
    public function getEventCreatedAt(): \DateTime
    {
        return $this->eventCreatedAt;
    }

    public function toArray(): array
    {

        $data = [
            "id" => $this->id
        ];

        foreach ($this->eventAttributes as $attribute) {
            $data[$attribute] = call_user_func([$this, $this->getGetter($attribute)]);
        }

        return [
            "eventId" => $this->eventId,
            "eventCreatedAt" => $this->eventCreatedAt,
            "data" => $data
        ];
    }
}
