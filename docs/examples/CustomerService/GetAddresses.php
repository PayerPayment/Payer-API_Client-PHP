<?php

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\CustomerService\GetAddressesRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $getAddressesRequest = new GetAddressesRequest($env['wsdl_location']['customer_service'], $env['options']);
    $getAddressesResponse = $getAddressesRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'regNumber' => '5561234567',
        'emailAddress' => null,
        'phoneNumber' => null,
        'zipCode' => '12151',
        'countryCode' => 'se',
        'additionalOptions' => null
      ]
    ]);

    var_dump($getAddressesResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }