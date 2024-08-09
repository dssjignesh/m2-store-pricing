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
namespace Dss\StorePricing\Observer\Preference\Catalog;

use Magento\Catalog\Observer\SwitchPriceAttributeScopeOnConfigChange as CoreClass;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Store\Model\Store;
use Dss\StorePricing\Helper\Data as StorePricingHelper;

class SwitchPriceAttributeScopeOnConfigChange extends CoreClass
{
    /**
     * @var StorePricingHelper
     */
    private $storePricingHelper;

    /**
     * @param ReinitableConfigInterface $config
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param StorePricingHelper $advPricingHelper
     */
    public function __construct(
        private ReinitableConfigInterface $config,
        private ProductAttributeRepositoryInterface $productAttributeRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        StorePricingHelper $advPricingHelper
    ) {
        $this->storePricingHelper = $advPricingHelper;
    }

    /**
     * Execute observer
     *
     * @param EventObserver $observer
     */
    public function execute(EventObserver $observer)
    {
        /*if (!$this->storePricingHelper->isActive() || !$this->storePricingHelper->isPriceStoreScope()) {
            parent::execute($observer);
            return $this;
        }*/

        $this->searchCriteriaBuilder->addFilter('frontend_input', 'price');
        $criteria = $this->searchCriteriaBuilder->create();

        $scope = $this->config->getValue(Store::XML_PATH_PRICE_SCOPE);
        $scope = ($scope == \Dss\StorePricing\Model\Config::STORE_SCOPE_PRICE_VALUE)
            ? ProductAttributeInterface::SCOPE_STORE_TEXT
            : (
                ($scope == Store::PRICE_SCOPE_WEBSITE)
                ? ProductAttributeInterface::SCOPE_WEBSITE_TEXT
                : ProductAttributeInterface::SCOPE_GLOBAL_TEXT
            );

        $priceAttributes = $this->productAttributeRepository->getList($criteria)->getItems();

        /** @var ProductAttributeInterface $priceAttribute */
        foreach ($priceAttributes as $priceAttribute) {
            $priceAttribute->setScope($scope);
            $this->productAttributeRepository->save($priceAttribute);
        }
    }
}
