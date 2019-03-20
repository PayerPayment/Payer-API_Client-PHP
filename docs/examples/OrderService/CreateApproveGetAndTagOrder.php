<?php

require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

use Payer\Api\SessionService\CreateSessionRequest;
use Payer\Api\SessionService\DestroySessionRequest;

use Payer\Api\OrderService\CreateOrderRequest;
use Payer\Api\OrderService\ApproveOrderRequest;
use Payer\Api\OrderService\GetApprovedOrdersWithoutTagRequest;
use Payer\Api\OrderService\TagOrdersRequest;

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
            'zipCode' => '',
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
            'subtotalPrice' => 10000,
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

    echo("approveOrder response\n:");
    var_dump($approveOrderResponse);

    
    $tag = 'php-sdk-test-tag';

    $getApprovedOrdersWithoutTagRequest = new GetApprovedOrdersWithoutTagRequest($env['wsdl_location']['order_service'], $env['options']);
    $getApprovedOrdersWithoutTagResponse = $getApprovedOrdersWithoutTagRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'tag' => $tag
      ]
    ]);

    #echo("getApprovedOrdersWithoutTag before tagging response\n:");
    #var_dump($getApprovedOrdersWithoutTagResponse);
    $found = false;
    $orders = $getApprovedOrdersWithoutTagResponse->orders;
    foreach ($orders as $order) {
      if ($order->orderId == $createOrderResponse->orderId) {
        $found = true;
        break;
      }
    }
    if ($found) {
      echo("Order does not have the tag so showed up in the response\n");
    } else {
      echo("Order did NOT exist in response - FAIL - the order should have been returned after being created and approved!\n");
    }

    $tagOrdersRequest = new TagOrdersRequest($env['wsdl_location']['order_service'], $env['options']);
    $tagOrdersResponse = $tagOrdersRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'tag' => $tag,
        'orderIds' => [ 
          $createOrderResponse->orderId
        ]
      ]
    ]);

    echo("Did tag order\n");
    #var_dump($tagOrdersResponse);

    $getApprovedOrdersWithoutTagResponseAfterTag = $getApprovedOrdersWithoutTagRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'tag' => $tag
      ]
    ]);

    $found = false;
    $orders = $getApprovedOrdersWithoutTagResponseAfterTag->orders;
    foreach ($orders as $order) {
      if ($order->orderId == $createOrderResponse->orderId) {
        $found = true;
        break;
      }
    }
    if (!$found) {
      echo("Order now has the tag so doesn't show up in the response\n");
    } else {
      echo("Order did exist in reponse - FAIL! It should not have been returned!\n");
    }

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }
