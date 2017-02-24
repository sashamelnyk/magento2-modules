<?php
 
namespace Demac\WelcomePlugin\Plugin;
 
use Magento\Checkout\Model\Cart\CartInterface;
use Magento\Framework\Message\ManagerInterface as MessageManager;

class AddTheCartMessage{
	
	private $messageManager;

	public function __construct(MessageManager $messageManager){
		$this->MessageManager = $messageManager;
	}

	public function afterAddProduct(CartInterface $cart, $result){
		$this->MessageManager->addNoticeMessage('При замовленні на суму від $150 доставка безкоштовна');
		$this->MessageManager->addWarningMessage('Ти бачиш це повідомлення, значить тобі пощастило!');
		return $result;
	}
}
