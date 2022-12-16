<?php
/**
 * Class Wishlist
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_ProductInquiry
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com */
namespace Risecommerce\ProductInquiry\Plugin\Wishlist\CustomerData;

class Wishlist extends \Magento\Wishlist\CustomerData\Wishlist
{
    /**
     * @var \Risecommerce\ProductInquiry\Helper\Data
     */
    private $helperData;

    /**
     * Wishlist constructor.
     *
     * @param \Magento\Wishlist\Helper\Data $wishlistHelper
     * @param \Magento\Wishlist\Block\Customer\Sidebar $block
     * @param \Magento\Catalog\Helper\ImageFactory $imageHelperFactory
     * @param \Magento\Framework\App\ViewInterface $view
     * @param \Risecommerce\ProductInquiry\Helper\Data $helperData
     * @param \Magento\Catalog\Model\Product\Configuration\Item\ItemResolverInterface|null $itemResolver
     */
    public function __construct(
        \Magento\Wishlist\Helper\Data $wishlistHelper,
        \Magento\Wishlist\Block\Customer\Sidebar $block,
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory,
        \Magento\Framework\App\ViewInterface $view,
        \Risecommerce\ProductInquiry\Helper\Data $helperData,
        \Magento\Catalog\Model\Product\Configuration\Item\ItemResolverInterface $itemResolver = null
    ) {
        $this->helperData = $helperData;
        return parent::__construct($wishlistHelper, $block, $imageHelperFactory, $view, $itemResolver);
    }

    /**
     * Retrieve wishlist item data
     *
     * @param \Magento\Wishlist\Model\Item $wishlistItem
     * @return array
     */
    protected function getItemData(\Magento\Wishlist\Model\Item $wishlistItem)
    {
        $getItemDataArray = parent::getItemData($wishlistItem);

        $productId = $wishlistItem->getProduct()->getId();
        $disclosePrice = $this->helperData->getDisclosePrice($productId);
        $allowAddToCart = $this->helperData->getAllowAddtocart($productId);

        $productInquiryCheckArray = [
            'allow_add_to_cart' => $allowAddToCart,
            'disclose_price' => $disclosePrice
        ];

        return array_merge($getItemDataArray, $productInquiryCheckArray);
    }
}
