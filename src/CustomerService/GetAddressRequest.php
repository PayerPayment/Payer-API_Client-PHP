<?php namespace Payer\Api\CustomerService;

use Payer\Api\SoapRequestInterface;
use SoapClient;

class GetAddressRequest implements SoapRequestInterface {

  private $client;

  public function __construct($url, array $options) {
    $this->client = new SoapClient ($url, $options);
  }

  public function create($data) {
    return $this->client->getAddress([
      'session' => $data['session'] ,
      'getAddress' => $data['request']
      ])->return;
  }

}