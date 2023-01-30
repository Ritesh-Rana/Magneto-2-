<?php
declare(strict_types=1);

namespace Mode\Gqmode\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;


/**
 * Order sales field resolver, used for GraphQL request processing
 */
class CustomerOrder implements ResolverInterface
{
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Directory\Model\Currency $currencyFormat
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->priceCurrency = $priceCurrency;
        $this->currencyFormat =$currencyFormat;
    }

    /**
     * Get current store currency symbol with price
     * $price price value
     * true includeContainer
     * Precision value 2
     */
    public function getCurrencyFormat($price)
    {
        return $this->getCurrencySymbol() . number_format((float)$price, \Magento\Framework\Pricing\PriceCurrencyInterface::DEFAULT_PRECISION);
    }

    /**
     * Get current store CurrencySymbol
     */
    public function getCurrencySymbol()
    {
        $symbol = $this->priceCurrency->getCurrencySymbol();
        return $symbol;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }
        
        $customerEmail = $this->getCustomerEmail($args);
        $month=$args['month'];
        $week=$args['week'];
        $salesData = $this->getSalesData($customerEmail,$month,$week);

        return $salesData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getCustomerEmail(array $args): string
    {
        if (!isset($args['customer_email'])) {
            throw new GraphQlInputException(__('Customer email must be specified.'));
        }

        return (string)$args['customer_email'];
    }

    /**
     * @param int $customerEmail
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getSalesData(string $customerEmail,$month,$week): array
    {
        try {
            /* filter for all customer orders */
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('customer_email', $customerEmail,'eq')->create();
            $orders = $this->orderRepository->getList($searchCriteria);

            $salesOrder = [];
            foreach($orders as $order) {

                $monday = date('Y-m-d', strtotime("this week"));
                $sunday = date('Y-m-d', strtotime('+6 day', strtotime($monday)));
                $orderdate= $order->getCreatedAt();
                
                $tdate = date('y-m-d');
                $explodetdate = explode('-',$tdate);
                $created_date = $order->getCreatedAt();
                $explodecreateddate = explode('-',$created_date);

                $explodecreateddate[0]=substr($explodecreateddate[0],-2);

                if($month==1) {
                    if ($explodetdate[0] == $explodecreateddate[0] && $explodetdate[1] == $explodecreateddate[1]) {
                        $orderId = $order->getId();
                        $salesOrder['OrderRecords'][$orderId]['increment_id'] = $order->getIncrementId();
                        $salesOrder['OrderRecords'][$orderId]['customer_name'] = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
                        $salesOrder['OrderRecords'][$orderId]['grand_total'] = $this->getCurrencyFormat($order->getGrandTotal());
                        $salesOrder['OrderRecords'][$orderId]['created_at'] = $order->getCreatedAt();
                        $salesOrder['OrderRecords'][$orderId]['shipping_method'] = $order->getShippingMethod();
                        $salesOrder['OrderRecords'][$orderId]['shipping_description'] = $order->getShippingDescription();
                        $salesOrder['OrderRecords'][$orderId]['shipping_amount'] = $order->getShippingAmount();
                        $salesOrder['OrderRecords'][$orderId]['total_qty_ordered'] = $order->getTotalQtyOrdered();
                        $salesOrder['OrderRecords'][$orderId]['state'] = $order->getState();
                        $salesOrder['OrderRecords'][$orderId]['status'] = $order->getStatus();
                    }
                }
                if($week==1){
                    if ($monday <= $orderdate && $orderdate <= $sunday) {
                        $orderId = $order->getId();
                        $salesOrder['OrderRecords'][$orderId]['increment_id'] = $order->getIncrementId();
                        $salesOrder['OrderRecords'][$orderId]['customer_name'] = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
                        $salesOrder['OrderRecords'][$orderId]['grand_total'] = $this->getCurrencyFormat($order->getGrandTotal());
                        $salesOrder['OrderRecords'][$orderId]['created_at'] = $order->getCreatedAt();
                        $salesOrder['OrderRecords'][$orderId]['shipping_method'] = $order->getShippingMethod();
                        $salesOrder['OrderRecords'][$orderId]['shipping_description'] = $order->getShippingDescription();
                        $salesOrder['OrderRecords'][$orderId]['shipping_amount'] = $order->getShippingAmount();
                        $salesOrder['OrderRecords'][$orderId]['total_qty_ordered'] = $order->getTotalQtyOrdered();
                        $salesOrder['OrderRecords'][$orderId]['state'] = $order->getState();
                        $salesOrder['OrderRecords'][$orderId]['status'] = $order->getStatus();
                    }
                }
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $salesOrder;
    }
}