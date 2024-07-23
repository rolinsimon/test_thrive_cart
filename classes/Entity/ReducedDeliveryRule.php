<?php
namespace classes\Entity;

use classes\Interface\DeliveryRuleInterface;

class ReducedDeliveryRule implements DeliveryRuleInterface {

    
    private Float $fromAmount = 50.00;
    private Float $toAmount = 89.99;
    private Float $price = 2.95;
    
    public function isInRange(float $cost): bool {
        return $cost >= $this->fromAmount &&  $cost < $this->toAmount ;
    }
    
    public function getPrice(): Float {
        return $this->price;
    }

}