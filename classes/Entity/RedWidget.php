<?php
namespace classes\Entity;

use classes\Interface\WidgetInterface;

class RedWidget implements WidgetInterface{

    public const CODE = "R01";

    private Float $price = 32.95;
    
    public function getCode(): string {
        return self::CODE;
    }
    
    public function getPrice(): Float {
        return $this->price;
    }
}