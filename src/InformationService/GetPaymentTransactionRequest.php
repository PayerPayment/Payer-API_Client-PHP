<?php namespace Payer\Api\InformationService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class GetPaymentTransactionRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->getPaymentTransaction([
        'session' => $data['session'] ,
        'getPaymentTransaction' => $data['request']
        ])->return;
    }

  }