<?php
namespace classes\Entity;

use classes\Interface\WidgetInterface;

class GreenWidget implements WidgetInterface {

    public const CODE = "G01";

    private Float $price = 24.95;

    public function getCode(): string {
        return self::CODE;
    }

    public function getPrice(): Float {
        return $this->price;
    }
}