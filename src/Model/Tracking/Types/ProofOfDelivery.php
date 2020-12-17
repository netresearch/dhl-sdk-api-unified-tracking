<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

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

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getDocumentUrl(): string
    {
        return $this->documentUrl;
    }

    public function getSigned(): ?Person
    {
        return $this->signed;
    }
}
