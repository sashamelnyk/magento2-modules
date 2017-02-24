<?php
namespace Magebuzz\HelloWorld\Controller\Index;


use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context, PageFactory $pageFactory)
    {
        $this->_resultPageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Hello World'));

        return $resultPage;
    }
}
