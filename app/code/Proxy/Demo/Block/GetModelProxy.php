<?php

namespace Proxy\Demo\Block;

use Magento\Framework\View\Element\Template;
use Proxy\Demo\Model\DemoProxy;
use Magento\Framework\View\Element\Template\Context;

class GetModelProxy extends Template{

    protected $demoProxy;

    public function __construct(Context $context,DemoProxy $demoProxy, array $data=[])
    {
        $this->demoProxy=$demoProxy;

        parent::__construct($context, $data);
    }

    public function bloc(){

//        $this->demoProxy->heavy_oprations();

        return 1;
    }
}