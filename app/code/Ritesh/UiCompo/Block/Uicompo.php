<?php

namespace Ritesh\UiCompo\Block;

use Magento\Framework\View\Element\Template;

class Uicompo extends Template{

    public function getTime(){
        return rand();
    }
}