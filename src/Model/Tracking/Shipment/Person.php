<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;

/**
 * Class Person
 *
 * Consignee.
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Person
{
    /**
     * @var string
     */
    public $organizationName;

    /**
     * @var string
     */
    public $familyName;

    /**
     * @var string
     */
    public $givenName;

    /**
     * @var string
     */
    public $name;
}
