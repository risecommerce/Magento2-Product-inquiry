<?php
/**
 * Class Data
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_ProductInquiry
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com 
 */

namespace Risecommerce\ProductInquiry\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $productFactory;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->_customerSession = $customerSession->create();
        $this->productFactory = $productFactory;
        parent::__construct($context);
    }

    /**
     * Get system configuration value
     *
     * @param string $configPath
     * @return mixed
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        return !empty(trim((string)$this->_customerSession->getCustomer()->getName())) ?
            $this->_customerSession->getCustomer()->getName() : '';
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return !empty(trim((string)$this->_customerSession->getCustomer()->getEmail())) ?
            $this->_customerSession->getCustomer()->getEmail() : '';
    }

    /**
     * Get product inquiry enabled or not from system configuration
     *
     * @return mixed
     */
    public function getInquiryEnabledGlobally()
    {
        return $this->getConfig('product_inquiry/general/enable');
    }

    /**
     * Get product inquiry title from system configuration
     *
     * @return mixed
     */
    public function getInquiryTitleGlobally()
    {
        return $this->getConfig('product_inquiry/general/label');
    }

    /**
     * Get add to cart button is visible or not from system configuration
     *
     * @return mixed
     */
    public function getAllowAddtocartGlobally()
    {
        return $this->getConfig('product_inquiry/general/is_addtocart_allowed');
    }

    /**
     * Get disclose price enabled or not from system configuration
     *
     * @return mixed
     */
    public function getDisclosePriceGlobally()
    {
        return $this->getConfig('product_inquiry/general/is_product_price_disclosed');
    }

    /**
     * Get product inquiry enabled or not individually per product
     *
     * @param int $productId
     * @return int
     */
    public function getInquiryEnabledProduct($productId)
    {
        $product = $this->productFactory->create()->load($productId);
        return $product->getIsProductInquiryEnable() != null ? $product->getIsProductInquiryEnable() : 0;
    }

    /**
     * Get product inquiry title individually per product
     *
     * @param int $productId
     * @return string
     */
    public function getInquiryTitleProduct($productId)
    {
        $product = $this->productFactory->create()->load($productId);
        return $product->getProductInquiryLabel() != null ? $product->getProductInquiryLabel() : '';
    }

    /**
     * Get add to cart button visible or not individually per product
     *
     * @param int $productId
     * @return int
     */
    public function getAllowAddtocartProduct($productId)
    {
        $product = $this->productFactory->create()->load($productId);
        return $product->getIsAddtocartAllowed() != null ? $product->getIsAddtocartAllowed() : 1;
    }

    /**
     * Get disclose individually per product
     *
     * @param int $productId
     * @return int
     */
    public function getDisclosePriceProduct($productId)
    {
        $product = $this->productFactory->create()->load($productId);
        return $product->getIsProductPriceDisclosed() != null ? $product->getIsProductPriceDisclosed() : 1;
    }

    /**
     * Get Inquiry Enabled or Not
     *
     * @param int $productId
     * @return bool
     */
    public function getInquiryEnabled($productId)
    {
        if ($this->getInquiryEnabledProduct($productId)) {
            return true;
        } elseif ($this->getInquiryEnabledGlobally()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get Inquiry Title
     *
     * @param int $productId
     * @return mixed|string
     */
    public function getInquiryTitle($productId)
    {
        $productInquiryTitle = '';
        if ($this->getInquiryEnabledProduct($productId)) {
            $productInquiryTitle = $this->getInquiryTitleProduct($productId);
        } elseif ($this->getInquiryEnabledGlobally()) {
            if ($this->getInquiryTitleGlobally() != null) {
                $productInquiryTitle = $this->getInquiryTitleGlobally();
            }
        }
        return $productInquiryTitle;
    }

    /**
     * Get Add to Cart visible or not
     *
     * @param int $productId
     * @return int|mixed
     */
    public function getAllowAddtocart($productId)
    {
        $allowAddtocart = 1;
        if ($this->getInquiryEnabledProduct($productId)) {
            $allowAddtocart = $this->getAllowAddtocartProduct($productId);
        } elseif ($this->getInquiryEnabledGlobally()) {
            if ($this->getAllowAddtocartGlobally() != null) {
                $allowAddtocart = $this->getAllowAddtocartGlobally();
            }
        }
        return $allowAddtocart;
    }

    /**
     * Get disclose price of product
     *
     * @param int $productId
     * @return int|mixed
     */
    public function getDisclosePrice($productId)
    {
        $disclosePrice = 1;
        if ($this->getInquiryEnabledProduct($productId)) {
            $disclosePrice = $this->getDisclosePriceProduct($productId);
        } elseif ($this->getInquiryEnabledGlobally()) {
            if ($this->getDisclosePriceGlobally() != null) {
                $disclosePrice = $this->getDisclosePriceGlobally();
            }
        }

        return $disclosePrice;
    }
}
