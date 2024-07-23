<?php
namespace classes\Entity;

use classes\Interface\SpecialOfferInterface;

class RedHalfPriceSpecialOffer implements SpecialOfferInterface {

    public function getReduction(array $widgetsList): Float {
        if (! array_key_exists(RedWidget::CODE, $widgetsList)) {
            return 0.00;
        }
        
        $quantityRed = $widgetsList[RedWidget::CODE]['quantity'];
        $reduction = $widgetsList[RedWidget::CODE]['price'] / 2;

        return number_format($reduction * floor($quantityRed / 2), 2);
        
        // if the offer can be apply only once by command the return line becomes
        //return $widgetsList[RedWidget::CODE]['quantity'] >=1 ? number_format($reduction, 2) : 0.00;
    }
}