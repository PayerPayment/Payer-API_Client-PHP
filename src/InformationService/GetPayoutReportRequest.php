<?php namespace Payer\Api\InformationService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class GetPayoutReportRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->getPayoutReport([
        'session' => $data['session'] ,
        'getPayoutReport' => $data['request']
        ])->return;
    }

  }