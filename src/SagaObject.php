<?php

namespace Alignwebs\SagaClient;

class SagaObject
{
    var $serviceName;
    var $successCase;
    var $failureCase;
    var $payload;

    function __construct(string $serviceName)
    {
        $this->serviceName = $serviceName;
    }

    public function getSagaObject()
    {
        return [
            $this->serviceName => [
                'successCase' => $this->successCase,
                'failureCase' => $this->failureCase,
                'payload' => $this->payload
            ],
        ];
    }

    public function successCase(string $url, string $method = "GET", string $expects = null)
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
    public function failureCase(string $url, string $method = "GET")
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
    public function payload(array $payload)
    {
        $this->payload = $payload;
    }

    // list valid http methods available
    public function validHttpMethods()
    {
        return ["GET", "POST", "PUT", "PATCH", "DELETE"];
    }
}
