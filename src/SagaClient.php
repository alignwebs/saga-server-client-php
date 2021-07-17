<?php

namespace Alignwebs\SagaClient;

use Alignwebs\SagaClient\SagaBuilder;

class SagaClient
{
    // The URL of the Saga server.
    private $sagaServerHost;

    function __construct($sagaServerHost)
    {
        $this->sagaServerHost = $sagaServerHost;
    }

    public function createSaga(SagaBuilder $sagaBuilder)
    {
        // Connect to the Saga server using curl and handle curl error.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->sagaServerHost . "/create");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sagaBuilder->getSaga()));
        // curl accept json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

        $response = curl_exec($ch);
        curl_close($ch);

        // handle error
        if ($response === false) {
            $error = curl_error($ch);
            throw new \Exception("Curl error: $error");
        }

        $response = json_decode($response, true);

        if (!isset($response['success']) || $response['success'] == false) {
            throw new \Exception("Error creating saga: " . $response['message']);
        }

        return $response['data']['sagaId'];
    }
}
