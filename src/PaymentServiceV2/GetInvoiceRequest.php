<?php namespace Payer\Api\PaymentServiceV2;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class GetInvoiceRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient($url, $options);
    }

    public function create($data) {
      return $this->client->getInvoice([
        'session' => $data['session'] ,
        'getInvoice' => $data['request']
        ])->return;
    }

  }