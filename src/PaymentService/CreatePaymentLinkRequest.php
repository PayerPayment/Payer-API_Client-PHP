<?php namespace Payer\Api\PaymentService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class CreatePaymentLinkRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient($url, $options);
    }

    public function create($data) {
      return $this->client->createPaymentLink([
        'session' => $data['session'] ,
        'createPaymentLink' => $data['request']
        ])->return;
    }

  }