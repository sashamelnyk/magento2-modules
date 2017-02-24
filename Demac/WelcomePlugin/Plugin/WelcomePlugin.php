<?php
 
namespace Demac\WelcomePlugin\Plugin;
 
use Magento\Framework\Message\ManagerInterface as MessageManager;
 
class WelcomePlugin {

	private $messageManager;
 
	public function __construct(MessageManager $messageManager){
	 
	    $this->messageManager = $messageManager;
	}
	
	public function afterSetCustomerDataAsLoggedIn(\Magento\Customer\Model\Session $session, $result){
	    $this->messageManager->addSuccessMessage("Моє дружнє повідомлення!");
	    return $result;
}
}

