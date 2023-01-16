<?php

namespace Ritesh\CustomerApi\Model;

use Magento\Catalog\Api\Data\ProductInterface;
use Ritesh\CustomerApi\Api\ProductRepoInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Catalog\Model\ProductRepository;

class OrderRepository implements ProductRepoInterface
{

protected $productFactory;
protected $data;
public function __construct(ProductRepository $productFactory,array $data=[])
{
   $this->productFactory=$productFactory;
   $this->data=$data;
   
}
 public function get($sku, $editMode = false, $storeId = null, $forceReload = false)
 {
    return $this->productFactory->get($sku);
 }
 public function getById($productId, $editMode = false, $storeId = null, $forceReload = false)
 {
    
 }
 public function delete(ProductInterface $product)
 {
    return "1";
    
 }
 public function save(ProductInterface $product, $saveOptions = false)
 {
    return "1";
    
 }
 public function deleteById($sku)
 {
    return "1";
    
 }
 public function getList(SearchCriteriaInterface $searchCriteria)
 {
    return "List";    
 }
}
