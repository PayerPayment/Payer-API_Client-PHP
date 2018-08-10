<?php namespace Payer\Api\CustomerService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class ValidateCreditRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->validateCredit([
        'session' => $data['session'] ,
        'validateCredit' => $data['request']
        ])->return;
    }

  }