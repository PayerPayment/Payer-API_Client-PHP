<?php namespace Payer\Api\OrderService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class GetApprovedOrdersRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->getApprovedOrders([
        'session' => $data['session'] ,
        'getApprovedOrders' => $data['request']
        ])->return;
    }

  }