<?php namespace Payer\Test\Integration;

/**
 * Class ApiClientTestCase
 *
 * @package Payer\Test\Integration
 */
class ApiClientTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    protected $env;

    /**
     * Setup shared environment configuration
     */
    protected function setUp()
    {
      $this->env = include(dirname(__FILE__) . '/../../config/env.php');
    }

}