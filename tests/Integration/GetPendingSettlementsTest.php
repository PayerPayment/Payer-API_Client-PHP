<?php namespace Payer\Test\Integration;

use Payer\Test\Integration\ApiClientTestCase;
use Payer\Test\Integration\Util\OrderStub;
use Payer\Api\SessionService\CreateSessionRequest;
use Payer\Api\SessionService\DestroySessionRequest;
use Payer\Api\OrderService\CreateOrderRequest;
use Payer\Api\PaymentService\GetPendingSettlementsRequest;

/**
 * Class SessionServiceTest
 *
 * @package Payer\Test\Integration\Soap
 */
class GetPendingSettlementsTest extends ApiClientTestCase
{

    /**
     * @var array CreateSessionResponse
     */
    private $createSessionResponse;

    /**
     * @var array CreateOrderResponse
     */
    private $createOrderResponse;

    protected function setUp()
    {
      parent::setUp();

      $createSessionRequest = new CreateSessionRequest($this->env['wsdl_location']['session_service'], $this->env['options']);
      $this->createSessionResponse = $createSessionRequest->create([ 'request' => $this->env['credentials'] ]);

      $createOrderRequest = new CreateOrderRequest($this->env['wsdl_location']['order_service'], $this->env['options']);
      $this->createOrderResponse = $createOrderRequest->create([ 'session' => $this->createSessionResponse, 'request' => OrderStub::generateCreateOrderRequestData()]);
    }

    protected function tearDown()
    {
      parent::tearDown();

      $destroySessionRequest = new DestroySessionRequest($this->env['wsdl_location']['session_service'], $this->env['options']);
      $destroySessionRequest->create([ 'request' => $this->createSessionResponse ]);
    }

    public function testGetPendingSettlements_ShouldReturnEntity()
    {
      try {

        $getPendingSettlementsRequest = new GetPendingSettlementsRequest($this->env['wsdl_location']['payment_service'], $this->env['options']);
        $getPendingSettlementsResponse = $getPendingSettlementsRequest->create([
          'session' => $this->createSessionResponse,
          'request' => [
            'orderId' => $this->createOrderResponse->orderId
          ]
        ]);

        $this->assertNotNull("Should return entity", $getPendingSettlementsResponse);

      } catch (Exception $e) {
        $this->fail("Should return array of pending settlemens.");

        echo json_encode([
          'message' => $e->getMessage(),
          'faultCode' => $e->detail->PayerFault->faultCode
        ]);
      }
    }

}