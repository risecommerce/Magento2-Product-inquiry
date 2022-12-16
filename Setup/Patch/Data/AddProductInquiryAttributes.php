<?php
/**
 * Class AddProductInquiryAttributes
 *
 * PHP version 8
 *
 * @category Risecommerce
 * @package  Risecommerce_ProductInquiry
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com */
namespace Risecommerce\ProductInquiry\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\ResourceModel\Product as ResourceProduct;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddProductInquiryAttributes implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * AddProductInquiryAttributes constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Add product inquiry attribute data
     *
     * @return AddProductInquiryAttributes|void
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $groupName = 'Product Inquiry';
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'is_product_inquiry_enable',
            [
                'type' => 'int',
                'input' => 'boolean',
                'label' => 'Enable',
                'required' => false,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'default' => '0',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'user_defined' => true,
                'sort_order' => 1,
                'group' => $groupName
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'product_inquiry_label',
            [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'Label',
                'required' => false,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'user_defined' => true,
                'sort_order' => 2,
                'group' => $groupName,
                'note' => 'Leave label as blank if you just want to hide price without having any inquiry button.'
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'is_addtocart_allowed',
            [
                'type' => 'int',
                'input' => 'boolean',
                'label' => 'Allow Add To Cart',
                'required' => false,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'default' => '1',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'user_defined' => true,
                'sort_order' => 3,
                'group' => $groupName
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'is_product_price_disclosed',
            [
                'type' => 'int',
                'input' => 'boolean',
                'label' => 'Disclose Product Price',
                'required' => false,
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'default' => '1',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'user_defined' => true,
                'sort_order' => 3,
                'group' => $groupName
            ]
        );

        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $eavSetup->getAttributeSetId($entityTypeId, 'Default');

        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, $groupName, 'is_product_inquiry_enable');
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, $groupName, 'product_inquiry_label');
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, $groupName, 'is_addtocart_allowed');
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, $groupName, 'is_product_price_disclosed');

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Get Aliases
     *
     * @return array
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Get dependencies
     *
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }
}
