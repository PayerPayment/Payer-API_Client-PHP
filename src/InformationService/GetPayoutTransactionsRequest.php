<?php namespace Payer\Api\InformationService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class GetPayoutTransactionsRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->getPayoutTransactions([
        'session' => $data['session'] ,
        'getPayoutTransactions' => $data['request']
        ])->return;
    }

  }