<?php
foreach (glob("classes/Interface/*") as $filename) {
    require $filename;
}
foreach (glob("classes/Entity/*") as $filename) {
    require $filename;
}
foreach (glob("classes/Handler/*") as $filename) {
    require $filename;
}

use classes\Handler\Basket;

if (PHP_SAPI !== 'cli' || php_sapi_name() !== 'cli') {
    die("CLI mode only");
}

/**
 * Main
 */
$main = Main::get();
// $main->run();
$main->unitTesting();

echo "\n" . str_pad('', 30, "-") . PHP_EOL;

exit();

class Main {

    private static $i = null;

    public function __construct() {}

    public static function get(): Main {
        if (self::$i === null) {
            self::$i = new static();
        }
        return self::$i;
    }

    function run(): void {
        try {
            $basket = new Basket();
            $basket->initiateBasket();

            $basket->addWidget("G01");

            $basket->addWidget("B01");
            $basket->addWidget("B01");

            $basket->addWidget("R01");
            $basket->addWidget("R01");
            $basket->addWidget("R01");

            print_r($basket->calculateTotals());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function unitTesting(): void {
        $basket = new Basket();
        $UNIT_TESTS = [
            'test 1' => [
                'expectedResult' => [
                    'subTotal' => 32.90,
                    'totalAfterOffers' => 32.90,
                    'totalAfterDelivery' => 37.85
                ],
                'expectedException' => null,
                'params' => [
                    "B01",
                    "G01"
                ]
            ],
            'test 2' => [
                'expectedResult' => [
                    'subTotal' => 65.9,
                    'totalAfterOffers' => 49.42,
                    'totalAfterDelivery' => 54.37
                ],
                'expectedException' => null,
                'params' => [
                    "R01",
                    "R01"
                ]
            ],
            'test 3' => [
                'expectedResult' => [
                    'subTotal' => 57.9,
                    'totalAfterOffers' => 57.9,
                    'totalAfterDelivery' => 60.85
                ],
                'expectedException' => null,
                'params' => [
                    "R01",
                    "G01"
                ]
            ],
            'test 4' => [
                'expectedResult' => [
                    'subTotal' => 114.75,
                    'totalAfterOffers' => 98.27,
                    'totalAfterDelivery' => 98.27
                ],
                'expectedException' => null,
                'params' => [
                    "B01",
                    "B01",
                    "R01",
                    "R01",
                    "R01"
                ]
            ],
            'test Empty' => [
                'expectedResult' => [
                    'subTotal' => 114.75,
                    'totalAfterOffers' => 98.27,
                    'totalAfterDelivery' => 98.27
                ],
                'expectedException' => "Empty basket",
                'params' => [
                ]
            ],
            'test Exception Code' => [
                'expectedResult' => [
                    'subTotal' => 32.90,
                    'totalAfterOffers' => 32.90,
                    'totalAfterDelivery' => 37.85
                ],
                'expectedException' => "Code Y01 doesn't exist",
                'params' => [
                    "B01",
                    "Y01"
                ]
            ]
        ];

        foreach ($UNIT_TESTS as $title => $data) {
            $basket->initiateBasket();
            echo $title . "\n";
            try {
                foreach ($data['params'] as $widgetCode) {
                    $basket->addWidget($widgetCode);
                }
                $nbError = 0;
                $results = $basket->calculateTotals();

                foreach ($results as $totalName => $totalValue) {
                    if ($data['expectedResult'][$totalName] !== $totalValue) {
                        $nbError ++;
                        echo "Wrong value -> " . $totalName . " expected : " .
                            $data['expectedResult'][$totalName] . " found : " . $totalValue . "\n";
                    }
                }
                echo "\n";
            } catch (\Exception $e) {
                if ($data['expectedException'] === null ||
                    $data['expectedException'] !== $e->getMessage()) {
                    $nbError ++;
                    echo "Wrong value -> Exception expected : " . $data['expectedException'] .
                        " found : " . $e->getMessage() . "\n";
                }
            }

            if ($nbError === 0) {
                echo $title . " --> All OK\n";
            } else {
                echo $title . " --> " . $nbError . " errors\n";
            }

            echo "_________________\n\n";
        }
    }
}