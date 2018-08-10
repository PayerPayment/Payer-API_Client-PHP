<?php namespace Payer\Api\SessionService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class DestroySessionRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->destroySession([ 'session' => $data['request'] ]);
    }

  }