<?php

namespace Abc\Def\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class EditCustomerAttributes implements ResolverInterface
{
    
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        // if (false === $context->getExtensionAttributes()->getIsCustomer()) {
        //     throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        // }
        return $args;
    }
}
