<?php

function addProduct(string $name, int $price): object
{
    $product = new stdClass();
    $product->name = $name;
    $product->price = $price;
    return $product;
}

$products = [
    $apple = addProduct('Apple \'Granny Smith\', ~160 g', 70),
    $raisins = addProduct('Golden Jumbo Raisins, 100 g', 153),
    $peanuts = addProduct('Salted peanuts, 150 g', 199),
    $breadCrisps = addProduct('Garlic & cheese Bread crisps, 180 g', 230),
    $gumBears = addProduct('Gummy Bears, 200 g', 265),
    $truffles = addProduct('Mini chocolate Truffle assorti, 200 g', 385)
];

$coins = [200, 100, 50, 20, 10, 5, 2, 1];
$formatAllCoins = [];
foreach ($coins as $coin) {
    $formatAllCoins[] = number_format($coin / 100, 2);
}
$stringAllCoins = implode(", ", $formatAllCoins);

echo "\n  G E T - A - S N A C K  \n";
echo "-------------------------\n\n";
echo "Type a number to select the product:\n";
for ($i = 0; $i < count($products); $i++) {
    $price = number_format($products[$i]->price / 100, 2);
    $productNumber = $i + 1;
    echo "[$productNumber] {$products[$i]->name}, $$price\n";
}

$validProduct = null;
$insertedCash = 0;

while (!$validProduct) {
    $selection = (int)readline('>> ');
    $selectedProduct = $products[$selection - 1];

    if (!in_array($selectedProduct, $products)) {
        echo "INVALID SELECTION, try again\n";
    } else {
        $validProduct = $selectedProduct;
    }
}

$formattedPrice = number_format($validProduct->price / 100, 2);
echo "You selected:\n $validProduct->name, $$formattedPrice\n";

while ($insertedCash < $validProduct->price) {
    echo "Insert coins ($stringAllCoins)\n";
    $insertedCoin = (float)readline('>> ');
    $coinInCentFormat = (int)($insertedCoin * 100);

    if (!in_array($coinInCentFormat, $coins)) {
        echo "INVALID COIN, try again\n";
    } else {
        $insertedCash += $coinInCentFormat;
    }

    $formattedInsertedCash = number_format($insertedCash / 100, 2);
    echo "Product price: $$formattedPrice\n";
    echo "Cash inserted: $$formattedInsertedCash\n";
}

echo "\nCash transaction successful\nThank you for your purchase!\n";

if ($insertedCash > $validProduct->price) {
    $remainder = $insertedCash - $validProduct->price;
    $returnedCoins = "Remainder:\n";

    foreach ($coins as $coin) {
        $coinCount = floor($remainder / $coin);
        if ($coinCount >= 1) {
            $formattedCoin = number_format($coin / 100, 2);
            $returnedCoins .= str_repeat("$$formattedCoin\n", $coinCount);
            $remainder -= $coin * $coinCount;
        }
    }
    echo $returnedCoins;
}