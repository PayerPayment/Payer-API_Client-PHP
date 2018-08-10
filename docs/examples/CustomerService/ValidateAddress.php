<?php

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\CustomerService\ValidateAddressRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $validateAddressRequest = new ValidateAddressRequest($env['wsdl_location']['customer_service'], $env['options']);
    $validateAddressResponse = $validateAddressRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'regNumber' => '4401127495',
        'address' => [
          'companyName' => null,
          'yourReference' => null,
          'title' => null,
          'firstName' => 'Testperson Lars Anders',
          'lastName' => 'Johansen',
          'streetAddress1' => 'Box 16993 Produtv, Bengtsbo',
          'streetAddress2' => null,
          'coAddress' => null,
          'houseAddress' => null,
          'zipCode' => '16993',
          'city' => 'Solna',
          'state' => null,
          'countryCode' => 'se',
        ],
        'additionalOptions' => null
      ]
    ]);

    var_dump($validateAddressResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }