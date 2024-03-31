<?php
namespace Mage\Mage\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;

class Product
{
    public static $counter = 0;
    public static $repository = null;
    public static $warningLimit = 5;
    public static function getById($productId){
        if (self::$counter > 5){
            trigger_error("You are loading single product too many times. Use Collection load instead ", E_USER_WARNING);
        }
        static::$counter++;
        if (!static::$repository){
            static::$repository = \Mage::get(ProductRepositoryInterface::class);     
        }
        return static::$repository->getById($productId);
    }

    public static function getBySku($productSku){
        if (self::$counter > 5){
            trigger_error("You are loading single product too many times. Use Collection load instead ", E_USER_WARNING);
        }
        static::$counter++;
        if (!static::$repository){
            static::$repository = \Mage::get(ProductRepositoryInterface::class);     
        }
        if (is_array($productSku)){
            return self::getbyFilter(['sku' => $productSku]);
        }
        return static::$repository->get($productSku);
    }

    public static function getByFilter($filters = [], SearchCriteriaInterface $searchCriteria = null, FilterBuilder $searchFilters = null){
        if (empty($filters) && $searchCriteria === null){
            throw new \Exception("Filters are empty");
        }
        if ($searchCriteria === null){
            $filterBuilder = \Mage::get(FilterBuilder::class);
            $searchCriteriaBuilder = \Mage::get(SearchCriteriaBuilder::class);
            $searchCriteria = \Mage::get(SearchCriteriaInterface::class);

            if (!isset($searchFilters)){
            $searchFilters = [];
            
            foreach ($filters as $filterKey => $filterValue){

                $operation = 'in';
                //if associated array
                if (!isset($filterValue[0])){
                    $operation = key($filterValue);
                    $filterValue = value($filterValue);
                }

                $searchFilters[] = $filterBuilder
                ->setField($filterKey)
                ->setConditionType($operation)
                ->setValue($filterValue)
                ->create();
            }
        }

            $searchCriteria = $searchCriteriaBuilder->addFilters($searchFilters)->create();
        }
        if (!static::$repository){
            static::$repository = \Mage::get(ProductRepositoryInterface::class);     
        }
        return static::$repository->getList($searchCriteria)->getItems();
    }
}   