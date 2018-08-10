<?php namespace Payer\Api\PaymentService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class GetPendingSettlementsRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->getPendingSettlements([
        'session' => $data['session'] ,
        'getPendingSettlements' => $data['request']
        ])->return;
    }

  }