<?php

$fieldSize = 3;
$field = [];
$fieldPositions = [];

// Make blank start field
for ($i = 0; $i < $fieldSize; $i++) {
    $row = [];
    for ($j = 0; $j < $fieldSize; $j++) {
        $row[$j] = "_";
    }
    $field[] = $row;
}

// Make field with marked position coordinates
for ($i = 0; $i < count($field); $i++) {
    $row = [];
    for ($j = 0; $j < count($field); $j++) {
        $row[$j] = $i . $j;
    }
    $fieldPositions[] = $row;
}

$winningCombinations = [];
// Find all winning combinations
$diagonalOne = [];
$diagonalTwo = [];
for ($i = 0; $i < count($fieldPositions); $i++) {
    $row = [];
    $column = [];
    for ($j = 0; $j < count($fieldPositions); $j++) {
        $row[$j] = $i . $j;
        $column[$j] = $j . $i;
        $diagonalOne[$j] = $j . $j;
        $diagonalTwo[$j] = count($fieldPositions) - $j - 1 . $j;
    }
    $winningCombinations[] = $row;
    $winningCombinations[] = $column;
}
$winningCombinations[] = $diagonalOne;
$winningCombinations[] = $diagonalTwo;

function showField()
{
    global $field;
    foreach ($field as $row) {
        echo implode(' ', $row) . "\n";
    }
}

echo "xoxoxoxoxoxox\n";
echo "  TIC\n";
echo "     TAC\n";
echo "        TOE\n";
echo "xoxoxoxoxoxox\n\n";

$playerOneSymbol = readline("Player 1, choose your symbol: ");
$playerTwoSymbol = readline("Player 2, choose your symbol: ");

$sizeCount = implode(", ", range(0, $fieldSize - 1));
echo "\nChoose cell by entering\ntwo numbers:\n";
echo "first indicates row ($sizeCount)\nsecond indicates column ($sizeCount)\n";

$moves = 0;
$cellCount = 0;
foreach ($fieldPositions as $position) {
    $cellCount += count($position);
}

while ($moves < $cellCount) {
    showField();

    echo $moves % 2 === 0 ? "Player $playerOneSymbol, " : "Player $playerTwoSymbol, ";
    $playerInput = readline('make your move: ');

    $validInput = false;
    foreach ($fieldPositions as $position) {
        if (in_array($playerInput, $position)) {
            $validInput = true;
        }
    }

    if (!$validInput) {
        echo "INVALID INPUT, enter two numbers to choose row and column\n";
        $moves--;
    } else {
        $inputStringValues = str_split($playerInput);
        $inputPositions = [];
        foreach ($inputStringValues as $value) {
            $inputPositions[] = (int)$value;
        }
        $cell = &$field[$inputPositions[0]][$inputPositions[1]];

        if ($cell !== '_') {
            echo "ERROR, you cannot mark vacant cell!\n";
            $moves--;
        }

        $cell = $moves % 2 === 0 ? $playerOneSymbol : $playerTwoSymbol;

        for ($i = 0; $i < count($winningCombinations); $i++) {
            $combination = &$winningCombinations[$i];
            if (in_array($playerInput, $combination)) {
                $index = array_search($playerInput, $combination);
                $combination[$index] = $moves % 2 === 0 ? $playerOneSymbol : $playerTwoSymbol;
            }

            if (count(array_unique($combination)) === 1) {
                $winner = implode('', array_unique($combination));
                echo "WE HAVE A WINNER!\nCongratulations, player $winner!\n";
                showField();
                exit;
            }
        }
    }
    $moves++;
}
echo "GAME OVER\n";
showField();