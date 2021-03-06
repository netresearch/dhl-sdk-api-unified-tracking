<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface ProofOfDeliveryInterface
 *
 * Describing data regarding handling of proof of delivery
 *
 * @api
 */
interface ProofOfDeliveryInterface
{
    /**
     * Timestamp of the delivery
     *
     * @return \DateTime
     */
    public function getTimeStamp(): \DateTime;

    /**
     * The link to related electronic proof of delivery document.
     *
     * @return string
     */
    public function getDocumentUrl(): string;

    /**
     * Person signing the proof of delivery
     *
     * @return PersonInterface|null
     */
    public function getSignee(): ?PersonInterface;
}
