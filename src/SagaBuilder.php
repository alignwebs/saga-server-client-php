<?php

namespace Alignwebs\SagaClient;

use Alignwebs\SagaClient\SagaObject;

class SagaBuilder
{
    var $sagaUid;
    var $sagaName;
    var $sagaFailedCallbacks = [];
    var $sagas = [];
    var $sagaCompletedEventPayload;

    function __construct(string $sagaName, string $sagaUid = null)
    {
        $this->sagaName = $sagaName;
        $this->sagaUid = $sagaUid;
    }

    // create saga method 
    public function addSagaEntry(SagaObject $sagaObject)
    {
        $object = $sagaObject->getSagaObject();
        $key = array_keys($object)[0];
        $value = array_values($object)[0];

        $this->sagas[$key] = $value;
    }

    // get sagas method
    public function getSagas()
    {
        return $this->sagas;
    }

    public function addSagaFailedCallback($url, $method, array $payload = [])
    {
        $this->sagaFailedCallbacks[] = [
            'url' => $url,
            'method' => $method,
            'payload' => $payload,
        ];
    }

    public function addSagaCompletedEventPayload(array $payload)
    {
        $this->sagaCompletedEventPayload = $payload;
    }

    // get saga method
    public function getSaga(): array
    {
        $saga['sagaUid'] = $this->sagaUid;
        $saga['sagaName'] = $this->sagaName;
        $saga['sagaFailedCallbacks'] = $this->sagaFailedCallbacks;
        $saga['sagas'] = $this->getSagas();
        return $saga;
    }
}
