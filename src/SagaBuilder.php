<?php

namespace Alignwebs\SagaClient;

use Alignwebs\SagaClient\SagaObject;

class SagaBuilder
{
    public ?string $sagaUid;
    public string $sagaName;
    public array $sagaFailedCallbacks = [];
    public array $sagas = [];
    public ?array $sagaCompletedEventPayload = null;

    public function __construct(string $sagaName, ?string $sagaUid = null)
    {
        $this->sagaName = $sagaName;
        $this->sagaUid = $sagaUid;
    }

    // create saga method 
    public function addSagaEntry(SagaObject $sagaObject): void
    {
        $object = $sagaObject->getSagaObject();
        $key = array_keys($object)[0];
        $value = array_values($object)[0];

        $this->sagas[$key] = $value;
    }

    // get sagas method
    public function getSagas(): array
    {
        return $this->sagas;
    }

    public function addSagaFailedCallback(string $url, string $method, array $payload = []): void
    {
        $this->sagaFailedCallbacks[] = [
            'url' => $url,
            'method' => $method,
            'payload' => $payload,
        ];
    }

    public function addSagaCompletedEventPayload(array $payload): void
    {
        $this->sagaCompletedEventPayload = $payload;
    }

    // get saga method
    public function getSaga(): array
    {
        $saga['sagaUid'] = $this->sagaUid;
        $saga['sagaName'] = $this->sagaName;
        $saga['sagaFailedCallbacks'] = $this->sagaFailedCallbacks;
        $saga['sagaCompletedEventPayload'] = $this->sagaCompletedEventPayload;
        $saga['sagas'] = $this->getSagas();
        return $saga;
    }
}
