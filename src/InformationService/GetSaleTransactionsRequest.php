<?php namespace Payer\Api\InformationService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class GetSaleTransactionsRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->getSaleTransactions([
        'session' => $data['session'] ,
        'getSaleTransactions' => $data['request']
        ])->return;
    }

  }