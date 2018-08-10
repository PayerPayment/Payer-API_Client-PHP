<?php namespace Payer\Test\Integration;

use Payer\Test\Integration\ApiClientTestCase;

use Payer\Api\SessionService\CreateSessionRequest;
use Payer\Api\SessionService\DestroySessionRequest;

/**
 * Class SessionServiceTest
 *
 * @package Payer\Test\Integration\Soap
 */
class SessionServiceTest extends ApiClientTestCase
{

    public function testManageSession_ShouldCreateAndDestroySession()
    {
      try {
        $createSessionRequest = new CreateSessionRequest($this->env['wsdl_location']['session_service'], $this->env['options']);
        $createSessionResponse = $createSessionRequest->create([ 'request' => $this->env['credentials'] ]);

        $this->assertNotNull("Should create session", $createSessionResponse);

        $destroySessionRequest = new DestroySessionRequest($this->env['wsdl_location']['session_service'], $this->env['options']);
        $destroySessionRequest->create([ 'request' => $createSessionResponse ]);

        $this->assertTrue(true);

      } catch (Exception $e) {
        $this->fail("Should not throw Exception.");

        echo json_encode([
          'message' => $e->getMessage(),
          'faultCode' => $e->detail->PayerFault->faultCode
        ]);
      }
    }

}