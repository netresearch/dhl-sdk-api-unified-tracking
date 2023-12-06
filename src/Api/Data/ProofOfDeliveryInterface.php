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
     */
    public function getTimeStamp(): \DateTime;

    /**
     * The link to related electronic proof of delivery document.
     */
    public function getDocumentUrl(): string;

    /**
     * Person signing the proof of delivery
     */
    public function getSignee(): ?PersonInterface;
}
