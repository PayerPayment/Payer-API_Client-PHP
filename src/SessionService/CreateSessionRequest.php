<?php namespace Payer\Api\SessionService;

  use Payer\Api\SoapRequestInterface;
  use SoapClient;

  class CreateSessionRequest implements SoapRequestInterface {

    private $client;

    public function __construct($url, array $options) {
      $this->client = new SoapClient ($url, $options);
    }

    public function create($data) {
      return $this->client->createSession([
        'agentId' => $data['request']['agent_id'],
        'username' => $data['request']['username'],
        'password' => $data['request']['password']
        ])->return;
    }

  }