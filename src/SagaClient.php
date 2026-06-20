<?php

namespace Alignwebs\SagaClient;

use Alignwebs\SagaClient\SagaBuilder;

class SagaClient
{
    // The URL of the Saga server.
    private string $sagaServerHost;

    public function __construct(string $sagaServerHost)
    {
        $this->sagaServerHost = $sagaServerHost;
    }

    public function createSaga(SagaBuilder $sagaBuilder): string
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $response = curl_exec($ch);

        // handle error
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Curl error: $error");
        }

        curl_close($ch);

        $response = json_decode($response, true);

        if (!isset($response['success']) || $response['success'] == false) {
            if (isset($response['data']) && is_array($response['data'])) {
                throw new \Exception("Error creating saga: " . $response['message'] . " : " . implode(", ", $response['data']));
            }
            throw new \Exception("Error creating saga: " . $response['message']);
        }

        return $response['data']['sagaId'];
    }
}
