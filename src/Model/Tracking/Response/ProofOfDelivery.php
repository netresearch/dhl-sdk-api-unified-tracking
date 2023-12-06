<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\PersonInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\ProofOfDeliveryInterface;

class ProofOfDelivery implements ProofOfDeliveryInterface
{
    public function __construct(
        private readonly \DateTime $timeStamp,
        private readonly string $documentUrl = '',
        private readonly ?PersonInterface $signee = null
    ) {
    }

    public function getTimeStamp(): \DateTime
    {
        return $this->timeStamp;
    }

    public function getDocumentUrl(): string
    {
        return $this->documentUrl;
    }

    public function getSignee(): ?PersonInterface
    {
        return $this->signee;
    }
}
