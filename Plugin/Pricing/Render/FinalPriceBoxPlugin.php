<?php
/**
 * Class FinalPriceBoxPlugin
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_ProductInquiry
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com */
namespace Risecommerce\ProductInquiry\Plugin\Pricing\Render;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Pricing\SaleableInterface;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Magento\Bundle\Pricing\Price\FinalPrice;
use Magento\Catalog\Pricing\Price\CustomOptionPrice;

class FinalPriceBoxPlugin extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * FinalPriceBoxPlugin constructor
     *
     * @param Context $context
     * @param SaleableInterface $saleableItem
     * @param PriceInterface $price
     * @param RendererPool $rendererPool
     * @param \Risecommerce\ProductInquiry\Helper\Data $helperData
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param array $data
     * @param SalableResolverInterface|null $salableResolver
     * @param MinimalPriceCalculatorInterface|null $minimalPriceCalculator
     */
    public function __construct(
        Context $context,
        SaleableInterface $saleableItem,
        PriceInterface $price,
        RendererPool $rendererPool,
        \Risecommerce\ProductInquiry\Helper\Data $helperData,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = [],
        SalableResolverInterface $salableResolver = null,
        MinimalPriceCalculatorInterface $minimalPriceCalculator = null
    ) {
        $this->helperData = $helperData;
        $this->productFactory = $productFactory;
        parent::__construct(
            $context,
            $saleableItem,
            $price,
            $rendererPool,
            $data,
            $salableResolver,
            $minimalPriceCalculator
        );
    }

    /**
     * Hide price for the bundle product if disclose price is disabled
     *
     * @return bool|void
     */
    public function showRangePrice()
    {
        $disclosePrice = $this->helperData->getDisclosePrice($this->getSaleableItem()->getId());

        if ($disclosePrice) {
            /** @var FinalPrice $bundlePrice */
            $bundlePrice = $this->getPriceType(FinalPrice::PRICE_CODE);
            $showRange = $bundlePrice->getMinimalPrice() != $bundlePrice->getMaximalPrice();

            if (!$showRange) {
                //Check the custom options, if any
                /** @var \Magento\Catalog\Pricing\Price\CustomOptionPrice $customOptionPrice */
                $customOptionPrice = $this->getPriceType(CustomOptionPrice::PRICE_CODE);
                $showRange =
                    $customOptionPrice->getCustomOptionRange(true) != $customOptionPrice->getCustomOptionRange(false);
            }

            return $showRange;
        } else {
            return;
        }
    }

    /**
     * Wrap disclose price into the result
     *
     * @param string $html
     * @return string
     */
    protected function wrapResult($html)
    {
        $disclosePrice = $this->helperData->getDisclosePrice($this->getSaleableItem()->getId());

        if ($disclosePrice) {
            return parent::wrapResult($html);
        } else {
            return;
        }
    }
}
