<?php
namespace Training\Registry\Controller\Repository;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
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
	public function __construct(
		Context $context,
		ProductRepositoryInterface $productRepository,
		SearchCriteriaBuilder $searchCriteriaBuilder
	) {
		parent::__construct($context);
		$this->productRepository = $productRepository;
		$this->searchCriteriaBuilder = $searchCriteriaBuilder;
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
}
