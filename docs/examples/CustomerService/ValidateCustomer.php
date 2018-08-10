<?php

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\CustomerService\ValidateCustomerRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $validateCustomerRequest = new ValidateCustomerRequest($env['wsdl_location']['customer_service'], $env['options']);
    $validateCustomerResponse = $validateCustomerRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'regNumber' => '8901166291',
        'emailAddress' => null,
        'phoneNumber' => null,
        'zipCode' => 'SE',
        'countryCode' => 'SE',
        'additionalOptions' => null
      ]
    ]);

    var_dump($validateCustomerResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }