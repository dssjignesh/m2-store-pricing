<?php

declare(strict_types=1);
/**
 * Digit Software Solutions.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  Dss
 * @package   Dss_StorePricing
 * @author    Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */
namespace Dss\StorePricing\Model\Preference\Catalog\Product\Attribute\Backend;

use Magento\Catalog\Model\Product\Attribute\Backend\Price as CorePrice;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class Price extends CorePrice
{
    /**
     * Set scope for the attribute
     *
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute
     * @return $this
     */
    public function setScope($attribute): self
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create(\Dss\StorePricing\Helper\Data::class);
        if (!$helper->isActive() || !$helper->isPriceStoreScope()) {
            return parent::setScope($attribute);
        }

        $attribute->setIsGlobal(ScopedAttributeInterface::SCOPE_STORE);
        return $this;
    }
}
