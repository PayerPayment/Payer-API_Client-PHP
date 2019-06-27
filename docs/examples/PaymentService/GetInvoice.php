<?php

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\PaymentService\CreateInvoiceRequest;
  use Payer\Api\PaymentService\GetInvoiceRequest;

  use Payer\Api\OrderService\CreateOrderRequest;
  use Payer\Api\OrderService\ApproveOrderRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $createOrderRequest = new CreateOrderRequest($env['wsdl_location']['order_service'], $env['options']);
    $createOrderResponse = $createOrderRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'clientIpAddress' => null,
        'referenceId' => uniqid(),
        'additionalReferenceId' => null,
        'description' => 'This is an description',
        'comment' => null,
        'currencyCode' => 'SEK',
        'currencyRate' => null,
        'purchaseChannel' => null,
        'storeId' => null,
        'URI' => null,
        'ourReference' => null,
        'project' => null,
        'invoiceCustomer' => [
          'customerNumber' => null,
          'customerType' => null,
          'regNumber' => '9164499353',
          'customerVatId' => null,
          'address' => [
            'companyName' => null,
            'yourReference' => null,
            'title' => null,
            'firstName' => 'Firstname',
            'lastName' => 'Lastname',
            'streetAddress1' => '',
            'streetAddress2' => null,
            'coAddress' => null,
            'houseAddress' => null,
            'zipCode' => '12345',
            'city' => '',
            'state' => null,
            'countryCode' => 'SE',
            'phoneNumber' => null,
            'emailAddress' => null
          ]
        ],
        'deliveryCustomer' => null,
        'ordererCustomer' => null,
        'items' => [
          [
            'position' => 1,
            'itemType' => 'INFOLINE',
            'articleNumber' => '#0001',
            'description' => 'This is an infoline',
            'quantity' => 0,
            'unit' => null,
            'unitPrice' => null,
            'unitVatAmount' => null,
            'vatPercentage' => 0,
            'subtotalPrice' => 0,
            'subtotalVatAmount' => 0,
          ],
          [
            'position' => 2,
            'itemType' => 'FREEFORM',
            'articleNumber' => '#0002',
            'description' => '',
            'quantity' => 1,
            'unit' => null,
            'unitPrice' => null,
            'unitVatAmount' => null,
            'vatPercentage' => 2500,
            'subtotalPrice' => 1000,
            'subtotalVatAmount' => 2500,
            'costCenter' => null,
            'additionalDetail' => null,
            'salesAccountCode' => null,
            'vatAccountCode' => null,
            'EAN' => null,
            'URI' => null
          ]
        ],
        'metaData' => [
          [
            'key' => 'testkey',
            'value' => 'testvalue'
          ]
        ],
        'options' => [
          'relaxed' => false,
          'test' => true,
          'additionalOptions' => null
        ]
      ]
    ]);

    $approveOrderRequest = new ApproveOrderRequest($env['wsdl_location']['order_service'], $env['options']);
    $approveOrderResponse = $approveOrderRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'orderId' => $createOrderResponse->orderId
      ]
    ]);

    $createInvoiceRequest = new CreateInvoiceRequest($env['wsdl_location']['payment_service'], $env['options']);
    $createInvoiceResponse = $createInvoiceRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'orderId' => $createOrderResponse->orderId,
        'options' => [
          'deliveryType' => null,
          'templateType' => null,
          'dueDays' => null,
          'additionalOptions' => null
        ]
      ]
    ]);

    $getInvoiceRequest = new GetInvoiceRequest($env['wsdl_location']['payment_service'], $env['options']);
    $getInvoiceResponse = $getInvoiceRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'invoiceNumber' => $createInvoiceResponse->invoiceNumber,
        'referenceId' => null
      ]
    ]);

    var_dump($getInvoiceResponse);

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }