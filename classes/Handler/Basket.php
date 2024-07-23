<?php
namespace classes\Handler;

use classes\Entity\DefaultDeliveryRule;
use classes\Entity\ReducedDeliveryRule;
use classes\Entity\FreeDeliveryRule;
use classes\Entity\RedHalfPriceSpecialOffer;

class Basket {

    public function __construct(
        private array $widgetsList = [],
        private array $deliveryRules = [],
        private array $offers = []) {}

    public function initiateBasket(): void {
        $this->widgetsList = [];
        foreach (get_declared_classes() as $className) {
            if (in_array('classes\Interface\WidgetInterface', class_implements($className))) {
                $class = new $className();

                $this->widgetsList[$class->getCode()] = [
                    'quantity' => 0,
                    'price' => $class->getPrice()
                ];
            }
        }

        $this->deliveryRules = [
            new DefaultDeliveryRule(),
            new ReducedDeliveryRule(),
            new FreeDeliveryRule()
        ];

        $this->offers = [
            new RedHalfPriceSpecialOffer()
        ];
    }

    private function verifyCode(string $code): void {
        if (! array_key_exists($code, $this->widgetsList)) {
            throw new \Exception("Code " . $code . " doesn't exist");
        }
    }

    public function addWidget(string $code): void {
        $this->verifyCode($code);
        $this->widgetsList[$code]['quantity'] ++;
    }

    public function removeWidget(string $code): void {
        $this->verifyCode($code);
        $this->widgetsList[$code]['quantity'] --;
    }

    public function adaptQuantityWidget(string $code, int $quantity): void {
        $this->verifyCode($code);
        $this->widgetsList[$code]['quantity'] = $quantity;
    }

    public function getSubTotal(): float {
        $subTotal = 0;
        foreach ($this->widgetsList as $widget) {
            $subTotal += $widget['quantity'] * $widget['price'];
        }
        return number_format($subTotal, 2);
    }

    private function applyOffers(float $cost): float {
        $totalAfterOffers = $cost;

        foreach ($this->offers as $offer) {
            $totalAfterOffers -= $offer->getReduction($this->widgetsList);
        }

        return number_format($totalAfterOffers, 2);
    }

    private function applyDeliveryCost(float $cost): float {
        $totalAfterDelivery = $cost;

        foreach ($this->deliveryRules as $rule) {
            if ($rule->isInRange($cost)) {
                $totalAfterDelivery += $rule->getPrice();
                break;
            }
        }

        return number_format($totalAfterDelivery, 2);
    }

    public function calculateTotals(): array {
        $subTotal = $this->getSubTotal();
        if ($subTotal === 0.00) {
            throw new \Exception("Empty basket");
        }
        $totalAfterOffers = $this->applyOffers($subTotal);
        $totalAfterDelivery = $this->applyDeliveryCost($totalAfterOffers);

        return [
            "subTotal" => $subTotal,
            "totalAfterOffers" => $totalAfterOffers,
            "totalAfterDelivery" => $totalAfterDelivery
        ];
    }
}
?>