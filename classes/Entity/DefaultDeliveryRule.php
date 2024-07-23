<?php
namespace classes\Entity;

use classes\Interface\DeliveryRuleInterface;

class DefaultDeliveryRule implements DeliveryRuleInterface {

    private Float $toAmount = 49.99;

    private Float $price = 4.95;

    public function isInRange(float $cost): bool {
        return $cost < $this->toAmount;
    }

    public function getPrice(): Float {
        return $this->price;
    }
}