<?php 

namespace Proxy\Demo\Model;

class DemoProxy {

    protected $link;
    protected $status;

    public function __construct(
        \Magento\Catalog\Model\Product\Attribute\Source\Status $status,
        \Magento\Catalog\Model\Product\Link $link
    )
    {
        $this->link=$link;
        $this->status=$status;
    }

    public function demo(){
        return true;
    }
}