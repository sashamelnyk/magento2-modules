<?php

namespace Training\EavBackend\Setup;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Table as TableSourceModel;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetup
     */
    private $eavSetup;
    private $catalogSetupFactory;
    private $customerSetupFactory;
    //private $storeManager;

    public function __construct(
	EavSetup $eavSetup, 
	CategorySetupFactory $categorySetupFactory,
	CustomerSetupFactory $customerSetupFactory
    )
    {
        $this->eavSetup = $eavSetup;
	$this->catalogSetupFactory = $categorySetupFactory;
	$this->customerSetupFactory = $customerSetupFactory;
	//$this->storeManager = $storeManager;
    }

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare('0.1.0', $context->getVersion(), '>=')) {
            $this->eavSetup->addAttribute(Product::ENTITY, 'compatible_condiments', [
                'label'            => 'Compatible Condiments',
                'type'             => 'varchar',
                'input'            => 'multiselect',
                'source'           => TableSourceModel::class,
                'backend'          => ArrayBackend::class,
                'required'         => false,
                'user_defined'     => true,
                'global'           => ScopedAttributeInterface::SCOPE_WEBSITE,
                'visible_on_front' => true,
                'group'            => 'Product Details',
                'option' => [
                    'values' => [
                        100 => 'Creme',
                        200 => 'Milk',
                        300 => 'Onions',
                        400 => 'Mustard',
                        500 => 'Ketchup',
                        600 => 'Sweet Chutney',
                        700 => 'Sugar',
                        800 => 'Honey',
                        900 => 'Chilly',
                    ]
                ],
            ]);
        }
        if (version_compare('0.1.5', $context->getVersion(), '>=')) {
		$catalogSetup = $this->catalogSetupFactory->create(['setup' => $setup]);
		$catalogSetup->updateAttribute(
			Product::ENTITY,
			'compatible_condiments',
			[
				'frontend_model' => \Training\EavBackend\Entity\Attribute\Frontend\HtmlList::class,
				'is_html_allowed_on_front' => 1,
			]
		);
        }
	if (version_compare($context->getVersion(), '0.2.0', '<')) {
		/** @var CustomerSetup $customerSetup */
		$customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
		$customerSetup->addAttribute(
			Customer::ENTITY,
			'priority',
			[
				'label' => 'Priority',
				'type' => 'int',
				'input' => 'select',
				'source' => \Training\EavBackend\Entity\Attribute\Source\CustomerPriority::class,
				'required' => 0,
				'system' => 0,
				'position' => 100
			]
		);
		$customerSetup->getEavConfig()->getAttribute('customer', 'priority')->setData('used_in_forms', ['adminhtml_customer'])->save();
	}
    }
}
