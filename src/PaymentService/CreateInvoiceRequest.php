<?php namespace Payer\Api\PaymentService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class CreateInvoiceRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient($url, $options);
    }

    public function create($data) {
      return $this->client->createInvoice([
        'session' => $data['session'] ,
        'createInvoice' => $data['request']
        ])->return;
    }

  }