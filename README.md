# PHP client for Laravel Saga Server

Install package:
`composer require alignwebs/saga-server-client-php`


Sample Code:

`<?php

include 'vendor/autoload.php';

use Alignwebs\SagaClient\SagaBuilder;
use Alignwebs\SagaClient\SagaClient;
use Alignwebs\SagaClient\SagaObject;

// make saga client object
$host = 'http://saga.hyperzod.test';
$sagaClient = new SagaClient($host);

$sagaName = "TestSaga";
$sagaBuilder = new SagaBuilder($sagaName, 11);

// SETTING SERVICE
$sagaObject = new SagaObject("setting");

$payload = array(
    'tenant_id' => 1,
    'business_name' => 'Meco Fresh',
    'store_type' => 'single',
);

$sagaObject->payload($payload);
$sagaObject->successCase("http://saga.hyperzod.test/testing/1", "GET", "success:true");
$sagaObject->failureCase("http://saga.hyperzod.test/testing/1/rollback", "POST");

$sagaBuilder->addSagaEntry($sagaObject);

try {
    $sagaId = ($sagaClient->createSaga($sagaBuilder));
    echo "Saga ID: " . $sagaId . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
`
