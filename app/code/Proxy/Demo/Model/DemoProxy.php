<?php

namespace Proxy\Demo\Model;

class DemoProxy
{
    protected $link;
    protected $status;

    public function __construct()
    {
        $this->heavy_oprations();
    }

    public function heavy_oprations()
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('Your text message');

        for ($i = 0; $i < 100; $i++) {
        }
    }
}
