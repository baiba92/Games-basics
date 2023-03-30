<?php

$words = [
    "meatballs",
    "paella",
    "chimichurri",
    "stew",
    "pho",
    "cheesecake"
];

$randomWord = $words[array_rand($words)];
$letters = str_split($randomWord);
$hiddenWord = str_split(str_repeat('_', count($letters)));

$lives = 3;

echo "~~~~~~~~~~~~~~~~~~~\n";
echo "   H A N G M A N\n";
echo "~~~~~~~~~~~~~~~~~~~\n";
echo " You have $lives chances\n   to guess wrong\nbefore you get HUNG!\n\n";

while ($lives > 0) {

    if ($lives === 2) {
        echo "\n |\n";
        echo " |\n";
        echo " |\n";
        echo " |\n";
        echo " |\n";
        echo "~~~~~~~~~~~";
    }
    if ($lives === 1) {
        echo " ______\n";
        echo " |    |\n";
        echo " |    O\n";
        echo " |\n";
        echo " |\n";
        echo " |\n";
        echo "~~~~~~~~~~~";
    }
    echo "\nLives left: $lives\n";
    echo implode('', $hiddenWord), "\n";
    $inputLetter = readline('Enter letter: ');

    if (!in_array($inputLetter, $letters)) {
        $lives--;
    }

    foreach ($letters as $letter) {
        if ($letter === $inputLetter) {
            $letterIndex = array_search($inputLetter, $letters);
            $hiddenWord[$letterIndex] = $inputLetter;
            $letters[$letterIndex] = 'x';

            if ($randomWord === implode('', $hiddenWord)) {
                echo "Congratulations, you guessed! The word was: $randomWord";
                exit;
            }
        }
    }
}
echo " ______\n";
echo " |    |\n";
echo " |    O\n";
echo " |   /|\\\n";
echo " |   / \\\n";
echo " |\n";
echo "~~~~~~~~~~~\n";
echo implode('', $hiddenWord), "\n";
echo "YOU DIED! The word was: $randomWord";