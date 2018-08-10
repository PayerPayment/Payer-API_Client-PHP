<?php

  require_once dirname(__FILE__) . "/../../../vendor/autoload.php";

  use Payer\Api\SessionService\CreateSessionRequest;
  use Payer\Api\SessionService\DestroySessionRequest;

  use Payer\Api\PaymentService\GetPendingSettlementsRequest;
  use Payer\Api\PaymentService\DoSettlementRequest;

  use Payer\Api\OrderService\CreateOrderRequest;
  use Payer\Api\OrderService\ApproveOrderRequest;

  $env = include(dirname(__FILE__) . "/../../../config/env.php");

  try {
    $createSessionRequest = new CreateSessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $createSessionResponse = $createSessionRequest->create([ 'request' => $env['credentials'] ]);

    $getPendingSettlementsRequest = new GetPendingSettlementsRequest($env['wsdl_location']['payment_service'], $options);
    $getPendingSettlementsResponse = $getPendingSettlementsRequest->create([
      'session' => $createSessionResponse,
      'request' => [
        'orderId' => 111222333
      ]
    ]);

    $pendingSettlements = $getPendingSettlementsResponse->settlements;
    if (!is_array($pendingSettlements))
        $pendingSettlements = [ $pendingSettlements ];

    foreach ($pendingSettlements as $settlement) {
        $doSettlementRequest = new DoSettlementRequest($env['wsdl_location']['payment_service'], $env['options']);
        $doSettlementResponse = $doSettlementRequest->create([
          'session' => $createSessionResponse,
          'request' => [
            'settlementId' => $settlement->settlementId,
          ]
        ]);

        var_dump($doSettlementResponse);
    }

    $destroySessionRequest = new DestroySessionRequest($env['wsdl_location']['session_service'], $env['options']);
    $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

  } catch (Exception $e) {
    echo json_encode([
      'message' => $e->getMessage(),
      'faultCode' => $e->detail->PayerFault->faultCode
    ]);
  }