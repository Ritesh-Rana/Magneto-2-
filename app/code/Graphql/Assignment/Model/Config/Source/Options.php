<?php

namespace GraphQL\Assignment\Model\Config\Source;


class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options= [
            ['value' => 'ml', 'label' => __('ML')],
            ['value' => 'kg', 'label' => __('KG')],
            ['value' => 'gm', 'label' => __('GM')],
            ['value' => 'l', 'label' => __('L')],
        ];
        return $this->_options;
    }
}
