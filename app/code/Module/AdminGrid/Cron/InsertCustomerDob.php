<?php

namespace Module\AdminGrid\Cron;

use Module\AdminGrid\Model\CustomRuleFactory;
use Magento\Customer\Model\Customer as CustomerRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Stdlib\DateTime\DateTime;

class InsertCustomerDob
{

    protected $CustomerData;
    protected $customerRepository;
    protected $date;
    protected $searchCriteria;

    public function __construct(
        CustomRuleFactory $CustomerData,
        CustomerRepository $customerRepository,
        DateTime $date,
        SearchCriteriaBuilder $searchCriteria
    ) {
        $this->CustomerData = $CustomerData;
        $this->customerRepository = $customerRepository;
        $this->date=$date;
        $this->searchCriteria=$searchCriteria;;
    }

    public function execute()
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/UpdateCustomeDob.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);

        $allCustomer = $this->customerRepository->getCollection()
                        ->addAttributeToSelect("*")->load();
        
        foreach ($allCustomer as $customer) {

            $insert = $this->CustomerData;
            $insert->addData([
                'email' => $customer->getEmail(),
                'dob' => $customer->getDob(),
                'greeting_status' => 0,
            ]);
            $logger->info($customer->getName());
            $insert->save();
        }
    }
}
