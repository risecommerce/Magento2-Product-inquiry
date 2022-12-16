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
namespace Risecommerce\ProductInquiry\Model\ResourceModel;


class ProductInquiry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define Maintable and primarykey
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('risecommerce_product_inquiry', 'entity_id');
    }
}
