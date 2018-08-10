<?php

  require_once dirname(__FILE__) . '/../../../src/PaymentService/AdjustCreditRequest.php';

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\PaymentService\AdjustCreditRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $adjustCreditRequest = new AdjustCreditRequest($env['wsdl_location']['payment_service'], $env['options']);
    $adjustCreditResponse = $adjustCreditRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'orderId' => 123456789,
        'creditAmount' => 10000,
        'vatPercentage' => 2500,
        'description' => null
      ]
    ]);

    var_dump($adjustCreditResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }