<?php

namespace Alignwebs\SagaClient;

use Alignwebs\SagaClient\SagaObject;

class SagaBuilder
{
    var $sagaUid;
    var $sagaName;
    var $sagas = [];

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

    // get saga method
    public function getSaga(): array
    {
        $saga['sagaUid'] = $this->sagaUid;
        $saga['sagaName'] = $this->sagaName;
        $saga['sagas'] = $this->getSagas();
        return $saga;
    }
}
