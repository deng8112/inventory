<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Inventory\Model\StockSourceLink\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Inventory\Model\ResourceModel\StockSourceLink as StockSourceLinkResourceModel;
use Magento\InventoryApi\Api\Data\StockSourceLinkInterface;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Save implements SaveInterface
{
    /**
     * @var StockSourceLinkResourceModel
     */
    private $stockSourceLinkResource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param StockSourceLinkResourceModel $stockSourceLinkResource
     * @param LoggerInterface $logger
     */
    public function __construct(
        StockSourceLinkResourceModel $stockSourceLinkResource,
        LoggerInterface $logger
    ) {
        $this->stockSourceLinkResource = $stockSourceLinkResource;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(StockSourceLinkInterface $stockSourceLink): int
    {
        // todo: implement validation

        try {
            $this->stockSourceLinkResource->save($stockSourceLink);
            return (int)$stockSourceLink->getStockId();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save Stock Source Link'), $e);
        }
    }
}
