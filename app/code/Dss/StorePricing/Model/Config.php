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
namespace Dss\StorePricing\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    public const STORE_SCOPE_PRICE_VALUE = 2;
    public const XML_PATH_ENABLED = 'dss_storepricing/general/enabled';
    public const XML_PATH_DEBUG = 'dss_storepricing/general/debug';
    public const XML_PATH_PRICE_SCOPE = 'catalog/price/scope';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Retrieve configuration flag value.
     *
     * @param string $xmlPath
     * @param ?int $storeId
     * @return bool
     */
    public function getConfigFlag(string $xmlPath, ?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Retrieve configuration value.
     *
     * @param string $xmlPath
     * @param ?int $storeId
     * @return ?string
     */
    public function getConfigValue(string $xmlPath, ?int $storeId = null): ?string
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if the module is enabled
     *
     * @param ?int $storeId
     * @return bool
     */
    public function isEnabled(?int $storeId = null): bool
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLED, $storeId);
    }

    /**
     * Check if debug mode is enabled
     *
     * @param ?int $storeId
     * @return bool
     */
    public function isDebugEnabled(?int $storeId = null): bool
    {
        return $this->getConfigFlag(self::XML_PATH_DEBUG, $storeId);
    }

    /**
     * Check if the price scope is set to store level
     *
     * @param ?int $storeId
     * @return bool
     */
    public function isPriceStoreScope(?int $storeId = null): bool
    {
        $active = $this->getConfigValue(self::XML_PATH_PRICE_SCOPE, $storeId);
        if ($active == static::STORE_SCOPE_PRICE_VALUE) {
            return true;
        }

        return false;
    }
}
