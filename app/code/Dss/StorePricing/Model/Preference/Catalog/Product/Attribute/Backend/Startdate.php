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

use Magento\Catalog\Model\Attribute\Backend\Startdate as CoreStartdate;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class Startdate extends CoreStartdate
{
    /**
     * Set attribute
     *
     * @param \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute
     * @return $this
     */
    public function setAttribute($attribute)
    {
        parent::setAttribute($attribute);
        $this->setScope($attribute);
        return $this;
    }

    /**
     * Set scope for the attribute
     *
     * @param \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute
     * @return $this
     */
    public function setScope($attribute)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create(\Dss\StorePricing\Helper\Data::class);
        if ($helper->isActive()
            && $helper->isPriceStoreScope()
            && $attribute->getAttributeCode() == 'special_from_date'
        ) {
            $attribute->setIsGlobal(ScopedAttributeInterface::SCOPE_STORE);
        }

        return $this;
    }
}
