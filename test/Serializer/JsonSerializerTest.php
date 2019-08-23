<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Test\Serializer;

use Dhl\Sdk\Group\Tracking\Serializer\JsonSerializer;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{

    public function testDecode()
    {
        $jsonResponse = <<<JSON
{
  "shipments": [
    {
      "id": 7777777770,
      "service": "express",
      "origin": {
        "address": {
          "countryCode": "NL",
          "postalCode": "1043 AG",
          "addressLocality": "Oderweg 2, AMSTERDAM"
        }
      },
      "destination": {
      "address": {
          "countryCode": "NL",
          "postalCode": "1043 AG",
          "addressLocality": "Oderweg 2, AMSTERDAM"
        }
      },
      "status": {
        "timestamp": "2018-03-02T07:53:47Z",
        "location": {
          "address": {
            "countryCode": "NL",
            "postalCode": "1043 AG",
            "addressLocality": "Oderweg 2, AMSTERDAM"
          }
        },
        "statusCode": "pre-transit",
        "status": "DELIVERED",
        "description": "JESSICA",
        "remark": "The shipment is pending completion of customs inspection.",
        "nextSteps": "The status will be updated following customs inspection."
      },
      "estimatedTimeOfDelivery": "2018-08-03T00:00:00Z",
      "estimatedDeliveryTimeFrame": {
        "estimatedFrom": "2018-08-03T00:00:00Z",
        "estimatedThrough": "2018-08-03T22:00:00Z"
      },
      "estimatedTimeOfDeliveryRemark": "By End of Day",
      "details": {
        "carrier": {
          "@type": "Organization",
          "organizationName": "EXPRESS"
        },
        "product": {
          "productName": "UNKNOWN - Product unknown"
        },
        "receiver": {
          "@type": "Person",
          "organizationName": "EXPRESS",
          "familyName": "Doe",
          "givenName": "John",
          "name": "John"
        },
        "sender": {
          "@type": "Person",
          "organizationName": "EXPRESS",
          "familyName": "Doe",
          "givenName": "John",
          "name": "John"
        },
        "proofOfDelivery": {
          "timestamp": "2018-09-05T16:33:00Z",
          "signatureUrl": "string",
          "documentUrl": "https://webpod.dhl.com/webPOD/DHLePODRequest",
          "signed": {
            "@type": "Person",
            "familyName": "Doe",
            "givenName": "John",
            "name": "John"
          }
        },
        "totalNumberOfPieces": 8,
        "pieceIds": [
          "JD014600006281230704",
          "JD014600002708681600",
          "JD014600006615052259",
          "JD014600006615052264",
          "JD014600006615052265",
          "JD014600006615052268",
          "JD014600006615052307",
          "JD014600002266382340",
          "JD014600002659593446",
          "JD014600006101653481",
          "JD014600006614884499"
        ],
        "weight": {
          "value": 253.5,
          "unitText": "kg"
        },
        "volume": {
          "value": 12600
        },
        "loadingMeters": 1.5,
        "dimensions": {
          "width": {
            "value": 20,
            "unitText": "cm"
          },
          "height": {
            "value": 18,
            "unitText": "cm"
          },
          "length": {
            "value": 35,
            "unitText": "cm"
          }
        },
        "references": {
          "number": "YZ3892406173",
          "type": "customer-reference"
        },
        "dgf:routes": [
          {
            "dgf:vesselName": "MAERSK SARAT",
            "dgf:voyageFlightNumber": "TR TRUCK",
            "dgf:airportOfDeparture": {
              "dgf:locationName": "GOTHENBURG",
              "dgf:locationCode": "AMS",
              "countryCode": "NL"
            },
            "dgf:airportOfDestination": {
              "dgf:locationName": "GOTHENBURG",
              "dgf:locationCode": "AMS",
              "countryCode": "NL"
            },
            "dgf:estimatedDepartureDate": "2017-10-10T09:00:00",
            "dgf:estimatedArrivalDate": "2017-20-10T09:00:00",
            "dgf:placeOfAcceptance": {
              "dgf:locationName": "GOTHENBURG"
            },
            "dgf:portOfLoading": {
              "dgf:locationName": "GOTHENBURG"
            },
            "dgf:portOfUnloading": {
              "dgf:locationName": "GOTHENBURG"
            },
            "dgf:placeOfDelivery": {
              "dgf:locationName": "GOTHENBURG"
            }
          }
        ]
      },
      "events": [
        {
          "timestamp": "2018-03-02T07:53:47Z",
          "location": {
            "address": {
              "countryCode": "NL",
              "postalCode": "1043 AG",
              "addressLocality": "Oderweg 2, AMSTERDAM"
            }
          },
          "statusCode": "pre-transit",
          "status": "DELIVERED",
          "description": "JESSICA",
          "remark": "The shipment is pending completion of customs inspection.",
          "nextSteps": "The status will be updated following customs inspection."
        }
      ]
    }
  ],
  "possibleAdditionalShipmentsUrl": [
    "/shipments?trackingNumber=7777777770&service=parcel-de",
    "/shipments?trackingNumber=7777777770&service=parcel-nl"
  ]
}
JSON;

        $subject = new JsonSerializer();
        $responseObject = $subject->decode($jsonResponse);

        $this->assertCount(1, $responseObject->shipments);
    }
}
