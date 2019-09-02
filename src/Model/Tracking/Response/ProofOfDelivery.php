<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Response;

use Dhl\Sdk\Group\Tracking\Api\Data\PersonInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\ProofOfDeliveryInterface;

class ProofOfDelivery implements ProofOfDeliveryInterface
{
    /**
     * @var \Datetime
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
     * @param \Datetime $timeStamp
     * @param string $documentUrl
     * @param PersonInterface|null $signee
     */
    public function __construct(\Datetime $timeStamp, string $documentUrl = '', PersonInterface $signee = null)
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
