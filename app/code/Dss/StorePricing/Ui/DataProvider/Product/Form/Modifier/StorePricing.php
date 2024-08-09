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
namespace Dss\StorePricing\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Dss\StorePricing\Model\Config as StorePricingConfig;

class StorePricing extends AbstractModifier
{
    /**
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private StoreManagerInterface $storeManager,
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @inheritDoc
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Modifies the meta data to include scope labels for pricing fields.
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $scopeLabel = $this->getPriceScopeLabel();
        $meta["product-details"]["children"]["container_price"]["children"]["price"]["arguments"]["data"]
        ["config"]["scopeLabel"] = $scopeLabel;
        $meta["advanced-pricing"]["children"]["container_special_price"]["children"]["special_price"]
        ["arguments"]["data"]["config"]["scopeLabel"] = $scopeLabel;
        $meta["advanced-pricing"]["children"]["container_special_from_date"]["children"]["special_from_date"]
        ["arguments"]["data"]["config"]["scopeLabel"] = $scopeLabel;
        $meta["advanced-pricing"]["children"]["container_special_to_date"]["children"]["special_to_date"]
        ["arguments"]["data"]["config"]["scopeLabel"] = $scopeLabel;
        $meta["advanced-pricing"]["children"]["container_cost"]["children"]["cost"]["arguments"]["data"]["config"]
        ["scopeLabel"] = $scopeLabel;
        $meta["advanced-pricing"]["children"]["container_msrp"]["children"]["msrp"]["arguments"]
        ["data"]["config"]["scopeLabel"] = $scopeLabel;
        return $meta;
    }

    /**
     * Retrieves the scope label for pricing based on store configuration.
     *
     * @return string
     */
    public function getPriceScopeLabel()
    {
        if ($this->storeManager->isSingleStoreMode()) {
            return '';
        }
        $scope = (int) $this->scopeConfig->getValue(
            Store::XML_PATH_PRICE_SCOPE,
            ScopeInterface::SCOPE_STORE
        );
        if ($scope == Store::PRICE_SCOPE_GLOBAL) {
            return '[GLOBAL]';
        } elseif ($scope == Store::PRICE_SCOPE_WEBSITE) {
            return '[WEBSITE]';
        } elseif ($scope == StorePricingConfig::STORE_SCOPE_PRICE_VALUE) {
            return '[STORE VIEW]';
        }
        return '';
    }
}
