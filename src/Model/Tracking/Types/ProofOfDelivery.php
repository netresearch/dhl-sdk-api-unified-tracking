<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class ProofOfDelivery
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class ProofOfDelivery
{
    /**
     * @var string
     */
    private $timestamp = '';

    /**
     * @var string
     */
    private $documentUrl = '';

    /**
     * @var Person|null
     */
    private $signed;

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getDocumentUrl(): string
    {
        return $this->documentUrl;
    }

    /**
     * @return Person|null
     */
    public function getSigned()
    {
        return $this->signed;
    }
}
