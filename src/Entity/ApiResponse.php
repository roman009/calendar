<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class ApiResponse
{
    /**
     * @var mixed
     * @Groups({"default_api_response_group"})
     */
    private $data;

    /**
     * @var array
     * @Groups({"default_api_response_group"})
     */
    private $meta;

    /**
     * @var array
     * @Groups({"default_api_response_group", "default"})
     */
    private $errors;

    public function __construct()
    {
        $this->meta = [];
        $this->data = [];
        $this->errors = [];
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return ApiResponse
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     *
     * @return ApiResponse
     */
    public function setMeta($meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $error
     *
     * @return ApiResponse
     */
    public function addError(array $error): self
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * @param array $errors
     *
     * @return ApiResponse
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
