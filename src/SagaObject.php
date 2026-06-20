<?php

namespace Alignwebs\SagaClient;

class SagaObject
{
    public string $serviceName;
    public ?array $successCase = null;
    public ?array $failureCase = null;
    public ?array $payload = null;

    public function __construct(string $serviceName)
    {
        $this->serviceName = $serviceName;
    }

    public function getSagaObject(): array
    {
        return [
            $this->serviceName => [
                'successCase' => $this->successCase,
                'failureCase' => $this->failureCase,
                'payload' => $this->payload
            ],
        ];
    }

    public function successCase(string $url, string $method = "GET", ?string $expects = null): void
    {
        // validate $url
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception("Invalid URL: {$url}");
        }
        // validate $method values as GET or POST
        if (!in_array($method, $this->validHttpMethods())) {
            throw new \Exception("Invalid method: {$method}");
        }
        // set success case array
        $this->successCase = [
            "url" => $url,
            "method" => $method,
            "expects" => $expects
        ];
    }

    // create failure case method with url and method
    public function failureCase(string $url, string $method = "GET"): void
    {
        // validate $url
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception("Invalid URL: {$url}");
        }
        // validate $method values as GET or POST
        if (!in_array($method, $this->validHttpMethods())) {
            throw new \Exception("Invalid method: {$method}");
        }
        // set failure case array
        $this->failureCase = [
            "url" => $url,
            "method" => $method
        ];
    }

    // set payload
    public function payload(array $payload): void
    {
        $this->payload = $payload;
    }

    // list valid http methods available
    public function validHttpMethods(): array
    {
        return ["GET", "POST", "PUT", "PATCH", "DELETE"];
    }
}
