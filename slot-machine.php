<?php

$board = [];
$ROWS = 3;
$COLUMNS = 4;
$cash = 0;
$playerBet = 0;
$MIN_BET = 1;
$MAX_BET = 10;

$winningLines = [
    [['x' => 0, 'y' => 0], ['x' => 0, 'y' => 1], ['x' => 0, 'y' => 2], ['x' => 0, 'y' => 3]],
    [['x' => 1, 'y' => 0], ['x' => 1, 'y' => 1], ['x' => 1, 'y' => 2], ['x' => 1, 'y' => 3]],
    [['x' => 2, 'y' => 0], ['x' => 2, 'y' => 1], ['x' => 2, 'y' => 2], ['x' => 2, 'y' => 3]],
    [['x' => 0, 'y' => 0], ['x' => 1, 'y' => 1], ['x' => 2, 'y' => 2], ['x' => 2, 'y' => 3]],
    [['x' => 2, 'y' => 0], ['x' => 1, 'y' => 1], ['x' => 0, 'y' => 2], ['x' => 0, 'y' => 3]],
    [['x' => 0, 'y' => 0], ['x' => 0, 'y' => 1], ['x' => 1, 'y' => 2], ['x' => 2, 'y' => 3]],
    [['x' => 2, 'y' => 0], ['x' => 2, 'y' => 1], ['x' => 1, 'y' => 2], ['x' => 0, 'y' => 3]]
];

function newSymbol(string $name, int $value): object
{
    $symbol = new stdClass();
    $symbol->name = $name;
    $symbol->value = $value;
    return $symbol;
}

$symbols = [
    $dollar = newSymbol("$", 5),
    $letterX = newSymbol("X", 4),
    $letterO = newSymbol("O", 3),
    $hashtag = newSymbol("#", 2),
    $exclMark = newSymbol("!", 1)
];

function generateRandomBoard(): void
{
    global $board, $ROWS, $COLUMNS, $symbols;
    for ($row = 0; $row < $ROWS; $row++) {
        $board[$row] = [];
        for ($i = 0; $i < $COLUMNS; $i++) {
            $board[$row][] = $symbols[array_rand($symbols)];
        }
    }
}

function displayBoard(): void
{
    global $board;
    foreach ($board as $row) {
        $symbolRow = [];
        foreach ($row as $symbol) {
            $symbolRow[] = $symbol->name;
        }
        echo implode(" - ", $symbolRow), "\n";
    }
}

echo "\nS L O T   M A C H I N E\n\n";

$play = "";
$gameCount = 0;

while (true) {
    global $board;

    if ($cash === 0) {
        if ($gameCount > 0) {
            echo "You ran out of cash!\n";
            echo "Do you want to play again?\n";
            $play = readline('Hit "enter" for go, type any key to exit >> ');
            if ($play !== "") {
                echo "GAME OVER.\nTotal games played: $gameCount,\nTotal cash: $cash $\n";
                exit;
            }
        }

        $validCashFormat = false;
        while (!$validCashFormat) {
            $inputCash = readline("Enter your cash: ");
            $cash = (int)$inputCash;

            if ($cash === 0 || strval($cash) !== $inputCash) {
                echo "ERROR, valid cash format is whole number more than 0.\n";
            } else {
                $validCashFormat = true;
            }
        }
        echo "\n";
        echo "Player cash: $cash\n";
    }

    $validBet = false;
    while (!$validBet) {
        echo "Type 'X' to cash out\nENTER YOUR BET (from $MIN_BET to $MAX_BET)\n";
        $playerBet = readline(">> ");

        if ($playerBet === "X") {
            echo "GAME OVER.\nYou played $gameCount games,\nTotal cash: $cash $\n";
            exit;
        } elseif (strval((int)$playerBet) !== $playerBet) {
            echo "INVALID BET FORMAT, enter whole number\n";
        } elseif ($playerBet < $MIN_BET || $playerBet > $MAX_BET) {
            echo "INVALID BET AMOUNT, try again\n";
        } elseif ($playerBet > $cash) {
            echo "Not enough cash for this bet, your cash amount: $cash $, try again\n";
        } else {
            $playerBet = (int)$playerBet;
            $validBet = true;
        }
    }
    echo "Bet for this spin: $playerBet $\n\n";

    $cash -= $playerBet;
    generateRandomBoard();
    displayBoard();

    $lineCount = 0;
    $winPerSpin = 0;
    foreach ($winningLines as $line) {
        $testLineSymbols = [];
        foreach ($line as $key => $position) {
            $testLineSymbols[] = $board[$position['x']][$position['y']]->name; // push symbols from current board
            // in line positions matching all winning lines
        }

        if (count(array_unique($testLineSymbols)) === 1) {
            $lineCount++;
            foreach ($symbols as $symbol) {
                if ($testLineSymbols[0] === $symbol->name) {
                    $winPerSpin += $symbol->value * $playerBet * count($testLineSymbols);
                    $cash += $winPerSpin;
                }
            }
        }
    }
    $gameCount++;

    if ($lineCount === 1) {
        echo "WE GOT A LINE!\n";
        echo "You won +$winPerSpin $!\n";
    } elseif ($lineCount > 1) {
        echo "WE GOT $lineCount LINES!\n";
        echo "You won +$winPerSpin $!\n";
    } else {
        echo "Loss: -$playerBet $\n";
    }
    echo "Total cash: $cash $\n";
}