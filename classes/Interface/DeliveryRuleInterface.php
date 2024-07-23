<?php
namespace classes\Interface;

interface DeliveryRuleInterface {

    function isInRange(float $cost): bool;

    function getPrice(): Float;
}
?>