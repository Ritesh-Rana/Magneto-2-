<?php

namespace Ritesh\CustomerApi\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface as MagentoOrderRepository;

class OrderRepository implements MagentoOrderRepository
{
    private $searchCriteriaBuilder;
    private $filterBuilder;
    private $orderRepository;
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        MagentoOrderRepository $orderRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->orderRepository = $orderRepository;
    }

    public function getByEmail($email)
    {
        $filter = $this->filterBuilder
            ->setField('customer_email')
            ->setValue($email)
            ->setConditionType('eq')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder->addFilter($filter)->create();
        return $this->orderRepository->getList($searchCriteria);
    }
    public function get($id)
    {
        
    }
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        
    }
    public function save(OrderInterface $entity)
    {
        
    }
    public function delete(OrderInterface $entity)
    {
        
    }
}
