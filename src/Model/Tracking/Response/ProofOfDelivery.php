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
    /**
     * @var \DateTime
     */
    private $timeStamp;

    /**
     * @var string
     */
    private $documentUrl;

    /**
     * @var PersonInterface|null
     */
    private $signee;

    /**
     * ProofOfDelivery constructor.
     *
     * @param \DateTime $timeStamp
     * @param string $documentUrl
     * @param PersonInterface|null $signee
     */
    public function __construct(\DateTime $timeStamp, string $documentUrl = '', PersonInterface $signee = null)
    {
        $this->timeStamp = $timeStamp;
        $this->documentUrl = $documentUrl;
        $this->signee = $signee;
    }

    public function getTimeStamp(): \DateTime
    {
        return $this->timeStamp;
    }

    public function getDocumentUrl(): string
    {
        return $this->documentUrl;
    }

    public function getSignee()
    {
        return $this->signee;
    }
}
