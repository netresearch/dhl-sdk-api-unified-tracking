<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;

class ProofOfDelivery
{
    /**
     * @var string
     */
    public $timestamp;

    /**
     * @var string
     */
    public $signatureUrl;

    /**
     * @var string
     */
    public $documentUrl;

    /**
     * @var Person
     */
    public $signed;
}
