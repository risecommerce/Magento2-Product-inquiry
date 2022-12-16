<?php
/**
 * Class ProductInquiry
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_ProductInquiry
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com */
namespace Risecommerce\ProductInquiry\Model;

class ProductInquiry extends \Magento\Framework\Model\AbstractModel
{
    public const CACHE_TAG = 'risecommerce_product_inquiry_post';

    /**
     * @var string
     */
    protected $_cacheTag = 'risecommerce_product_inquiry_post';
    /**
     * @var string
     */
    protected $_eventPrefix = 'risecommerce_product_inquiry_post';

    /**
     * ProductInquiry Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Risecommerce\ProductInquiry\Model\ResourceModel\ProductInquiry::class);
    }
}
