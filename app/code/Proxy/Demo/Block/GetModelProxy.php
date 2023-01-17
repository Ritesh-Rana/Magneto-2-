<?php

namespace Proxy\Demo\Block;

use Proxy\Demo\Model\DemoProxy;

class GetModelProxy{

    protected $demoProxy;
    
    public function __construct(DemoProxy $demoProxy)
    {
        $this->demoProxy=$demoProxy;
    }
}