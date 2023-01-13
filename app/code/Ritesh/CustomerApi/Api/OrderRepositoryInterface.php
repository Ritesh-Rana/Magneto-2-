<?php
namespace Ritesh\CustomeApi\Api;

interface OrderRepositoryInterface
{
    public function getByEmail($email);
}
