<?php

function createElement(string $name, string ...$beats): object {
    $element = new stdClass();
    $element->name = $name;
    $element->beats = [...$beats];
    return $element;
}

$elements = [
    $element_lizard = createElement('lizard', 'paper', 'spock'),
    $element_spock = createElement('spock', 'scissors', 'rock'),
    $element_rock = createElement('rock', 'scissors', 'lizard'),
    $element_paper = createElement('paper', 'rock', 'spock'),
    $element_scissors = createElement('scissors', 'paper', 'lizard')
];

$stringAllElements = "";
foreach ($elements as $element) {
    $stringAllElements .= "$element->name   ";
}

$maxRounds = 5;
$currentRound = 0;
$pcWins = 0;
$playerWins = 0;
$ties = 0;

echo "------------------------------------------\n";
echo "  ROCK, PAPER, SCISSORS.  LIZARD, SPOCK.\n";
echo "               let's go!\n";
echo "      We're going to play $maxRounds rounds\n\n";

while ($currentRound < $maxRounds) {

    $currentRound++;
    echo "Round [ $currentRound ]\n";
    echo "------------------------------------------\n";
    echo "MAKE YOUR CHOICE FROM ONE OF THESE OPTIONS:\n";
    echo "$stringAllElements\n";

    $pcSelection = $elements[array_rand($elements)];
    $playerSelection = readline('Enter here >> ');
    echo "PC chose $pcSelection->name.\n";

    if ($pcSelection->name === $playerSelection) {
        echo "It's a tie!\n\n";
        $ties++;
    } elseif (in_array($playerSelection, $pcSelection->beats)) {
        echo "PC won.\n\n";
        $pcWins++;
    } else {
        echo "You won!\n\n";
        $playerWins++;
    }
}

echo "GAME OVER!\n";
echo "Ties: $ties, PC: $pcWins, Player: $playerWins";