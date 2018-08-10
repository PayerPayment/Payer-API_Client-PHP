<?php namespace Payer\Api\CustomerService;

use Payer\Api\SoapRequestInterface;
use SoapClient;

class GetAddressesRequest implements SoapRequestInterface {

  private $client;

  public function __construct($url, array $options) {
    $this->client = new SoapClient ($url, $options);
  }

  public function create($data) {
    return $this->client->getAddresses([
      'session' => $data['session'] ,
      'getAddresses' => $data['request']
      ])->return;
  }

}