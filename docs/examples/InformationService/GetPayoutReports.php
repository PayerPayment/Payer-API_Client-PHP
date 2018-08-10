<?php

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\InformationService\GetPayoutReportsRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $getPayoutReportsRequest = new GetPayoutReportsRequest($env['wsdl_location']['information_service'], $env['options']);
    $getPayoutReportsResponse = $getPayoutReportsRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'fromDate' => null,
        'toDate' => null
      ]
    ]);

    var_dump($getPayoutReportsResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }