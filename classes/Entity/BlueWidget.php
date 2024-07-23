<?php
namespace classes\Entity;

use classes\Interface\WidgetInterface;

class BlueWidget implements WidgetInterface{

    public const CODE = "B01";

    private Float $price = 7.95;

    public function getCode(): string {
        return self::CODE;
    }

    public function getPrice(): Float {
        return $this->price;
    }
}