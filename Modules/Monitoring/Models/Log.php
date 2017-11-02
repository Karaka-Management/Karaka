<?php

class Log implements \JsonSerializable
{
    private $id = 0;

    private $createdAt = null;

    private $createdBy = null;

    private $raw = '';

    private $layout = 0;

    public function __construct(string $message = '', int $layout = 0) 
    {

    }

    public function get(string $key) : string
    {
        return '';
    }

    public function toArray() : array
    {
        return [];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}