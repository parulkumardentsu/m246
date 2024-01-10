<?php

declare(strict_types=1);

namespace Dentsu\POC\Observer\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;


class RegisterSuccess implements \Magento\Framework\Event\ObserverInterface
{
    private $customerRepository;
    protected $resultFactory;
    protected $_request;

    const TRAINER_GROUPID = 2;
    const TRAINER_GROUPNAME = 'trainer';

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        CustomerRepositoryInterface $customerRepository,
        ResultFactory $resultFactory
    ) {
        $this->_request = $request;
        $this->customerRepository = $customerRepository;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {

        $id = $observer->getEvent()->getCustomer()->getId();
        $customer = $this->customerRepository->getById($id);

        $customerGroupName = $this->_request->getParam('trainer-selection');

        if ($customerGroupName == self::TRAINER_GROUPNAME) {
            $customer->setGroupId(self::TRAINER_GROUPID);
        }

        $this->customerRepository->save($customer);
    }
}
