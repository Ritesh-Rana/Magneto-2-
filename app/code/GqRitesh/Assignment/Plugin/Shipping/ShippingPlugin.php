<?php

namespace GqRitesh\Assignment\Plugin\Shipping;

class Shipping
{
    public function aroundIsShippingCarrierAvailable(
        \Magento\Shipping\Model\Shipping $subject,
        callable $proceed,
        $carrierCode,
        \Magento\Quote\Model\Quote\Address\RateRequest $request
    ) {
        // Your custom logic before the original method is called

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/code.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info($carrierCode."<br>");
        $result = $proceed($carrierCode, $request);

        return $result;
    }
}
