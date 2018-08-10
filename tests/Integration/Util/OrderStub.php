<?php namespace Payer\Test\Integration\Util;

class OrderStub
{

  public static function generateCreateOrderRequestData() {
    return [
        'clientIpAddress' => null,
        'referenceId' => uniqid(),
        'additionalReferenceId' => null,
        'description' => 'This is an description',
        'comment' => null,
        'currencyCode' => 'SEK',
        'currencyRate' => null,
        'purchaseChannel' => null,
        'storeId' => null,
        'URI' => null,
        'ourReference' => null,
        'project' => null,
        'invoiceCustomer' => [
          'customerNumber' => null,
          'customerType' => null,
          'regNumber' => '9164499353',
          'customerVatId' => null,
          'address' => [
            'companyName' => null,
            'yourReference' => null,
            'title' => null,
            'firstName' => 'Firstname',
            'lastName' => 'Lastname',
            'streetAddress1' => '',
            'streetAddress2' => null,
            'coAddress' => null,
            'houseAddress' => null,
            'zipCode' => '',
            'city' => '',
            'state' => null,
            'countryCode' => 'SE',
            'phoneNumber' => null,
            'emailAddress' => null
          ]
        ],
        'deliveryCustomer' => null,
        'ordererCustomer' => null,
        'items' => [
          [
            'position' => 1,
            'itemType' => 'INFOLINE',
            'articleNumber' => '#0001',
            'description' => 'This is an infoline',
            'quantity' => 0,
            'unit' => null,
            'unitPrice' => null,
            'unitVatAmount' => null,
            'vatPercentage' => 0,
            'subtotalPrice' => 0,
            'subtotalVatAmount' => 0,
          ],
          [
            'position' => 2,
            'itemType' => 'FREEFORM',
            'articleNumber' => '#0002',
            'description' => '',
            'quantity' => 1,
            'unit' => null,
            'unitPrice' => null,
            'unitVatAmount' => null,
            'vatPercentage' => 2500,
            'subtotalPrice' => 1000,
            'subtotalVatAmount' => 2500,
            'costCenter' => null,
            'additionalDetail' => null,
            'salesAccountCode' => null,
            'vatAccountCode' => null,
            'EAN' => null,
            'URI' => null
          ]
        ],
        'metaData' => [
          [
            'key' => 'testkey',
            'value' => 'testvalue'
          ]
        ],
        'options' => [
          'relaxed' => false,
          'test' => true,
          'additionalOptions' => null
        ]
    ];
  }

}