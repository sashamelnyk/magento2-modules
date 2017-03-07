<?php
namespace Training\Repository\Controller\Repository;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Product extends Action
{
	/**
	* @var ProductRepositoryInterface
	*/
	private $productRepository;
	/**
	* @var SearchCriteriaBuilder
	*/
	private $searchCriteriaBuilder;
	private $filterBuilder;

	public function __construct(
		Context $context,
		ProductRepositoryInterface $productRepository,
		SearchCriteriaBuilder $searchCriteriaBuilder,
		FilterBuilder $filterBuilder
	) {
		parent::__construct($context);
		$this->productRepository = $productRepository;
		$this->searchCriteriaBuilder = $searchCriteriaBuilder;
		$this->filterBuilder = $filterBuilder;
	}

	public function execute()
	{
		$this->getResponse()->setHeader('Content-Type', 'text/plain');
		$products = $this->getProductsFromRepository();
		foreach ($products as $product) {
			$this->outputProduct($product);
		}
	}
	/**
	* @return ProductInterface[]
	*/
	private function getProductsFromRepository()
	{
		$this->setProductTypeFilter();
		$criteria = $this->searchCriteriaBuilder->create();
		$products = $this->productRepository->getList($criteria);
		return $products->getItems();
	}
	private function outputProduct(ProductInterface $product)
	{
		$this->getResponse()->appendBody(sprintf(
		"%s - %s (%d)\n",
		$product->getName(),
		$product->getSku(),
		$product->getId())
		);
	}
	private function setProductTypeFilter()
	{
		$configProductFilter = $this->filterBuilder
			->setField('type_id')
			->setValue(\Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE)
			->setConditionType('eq')
			->create();
		$this->searchCriteriaBuilder->addFilters([$configProductFilter]);
	}
}
