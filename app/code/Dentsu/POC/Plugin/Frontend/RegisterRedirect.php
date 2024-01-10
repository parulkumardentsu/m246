<?php

namespace Dentsu\POC\Plugin\Frontend;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;

class RegisterRedirect
{
    protected $url;
    protected $resultFactory;
    protected $_request;

    public function __construct(UrlInterface $url, ResultFactory $resultFactory, \Magento\Framework\App\RequestInterface $request,)
    {
        $this->url = $url;
        $this->resultFactory = $resultFactory;
        $this->_request = $request;
    }

    public function aroundGetRedirect($subject, \Closure $proceed)
    {

        $customerGroupName = $this->_request->getParam('trainer-selection');

        if ($customerGroupName == 'trainer') {
            /** @var \Magento\Framework\Controller\Result\Redirect $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $result->setUrl($this->url->getUrl('sales/order/history/'));
            return $result;
        }

        return $proceed();
    }
}
