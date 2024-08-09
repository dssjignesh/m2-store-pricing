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
namespace Dss\StorePricing\Plugin\Model\Catalog\Config\Source\Price;

use Dss\StorePricing\Helper\Data as StorePricingHelper;
use Dss\StorePricing\Model\Config;

class Scope
{
    /**
     * @param StorePricingHelper $storePricingHelper
     */
    public function __construct(
        protected StorePricingHelper $storePricingHelper
    ) {
    }

    /**
     * Adds the "Store View" option to the price scope dropdown.
     *
     * @param \Magento\Catalog\Model\Config\Source\Price\Scope $subject
     * @param array $result
     * @return array
     */
    public function afterToOptionArray(
        \Magento\Catalog\Model\Config\Source\Price\Scope $subject,
        $result
    ) {
        $result[] = [
            'value' => Config::STORE_SCOPE_PRICE_VALUE,
            'label' => __('Store View')
        ];
        return $result;
    }
}
