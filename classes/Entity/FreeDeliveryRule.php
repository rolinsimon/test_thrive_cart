<?php
namespace classes\Entity;

use classes\Interface\DeliveryRuleInterface;

class FreeDeliveryRule implements DeliveryRuleInterface {

    private Float $fromAmount = 90.00;

    private Float $price = 0.00;
    
    
    public function isInRange(float $cost): bool {
        return $cost >= $this->fromAmount;
    }
    
    public function getPrice(): Float {
        return $this->price;
    }
}