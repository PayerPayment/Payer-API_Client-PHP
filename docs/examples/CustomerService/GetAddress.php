<?php

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\CustomerService\GetAddressRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $getAddressRequest = new GetAddressRequest($env['wsdl_location']['customer_service'], $env['options']);
    $getAddressResponse = $getAddressRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'regNumber' => '4401127495',
        'emailAddress' => null,
        'phoneNumber' => null,
        'zipCode' => '12151',
        'countryCode' => 'se',
        'additionalOptions' => null
      ]
    ]);

    var_dump($getAddressResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }