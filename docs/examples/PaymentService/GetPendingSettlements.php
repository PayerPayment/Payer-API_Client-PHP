<?php

require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

use Payer\Api\SessionService\CreateSessionRequest;
use Payer\Api\SessionService\DestroySessionRequest;

use Payer\Api\PaymentService\GetPendingSettlementsRequest;

$env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $getPendingSettlementsRequest = new GetPendingSettlementsRequest($env['wsdl_location']['payment_service'], $env['options']);
    $getPendingSettlementsResponse = $getPendingSettlementsRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'orderId' => 111222333
      ]
    ]);

    var_dump($getPendingSettlementsResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }