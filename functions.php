<?php

// Array of card images
$suits = ['Spades', 'Clubs', 'Hearts', 'Diamonds'];
$values = [
    'Ace' => 1,
    '2' => 2,
    '3' => 3,
    '4' => 4,
    '5' => 5,
    '6' => 6,
    '7' => 7,
    '8' => 8,
    '9' => 9,
    '10' => 10,
    'Jack' => 10,
    'Queen' => 10,
    'King' => 10
];

$players = ['p1' => 'Player 1', 'p2' => 'Player 2'];

/**
 * Builds deck with values and image paths
 *
 * @param $suits
 *              Suits array
 * @param $values
 *               Values array
 *
 * @return mixed
 *              Returns complete deck
 */
function build_deck(array $suits, array $values) :array {
    $deck = [];
    foreach ($suits as $suit) {
        foreach (array_keys($values) as $valueKey) {
            $deck["$valueKey of $suit"] = ['value' => $values[$valueKey], 'image' => "$valueKey$suit.svg"];
        }
    }
    return $deck;
}

/**
 * Creates empty array of player's scores
 *
 * @param $players
 *
 * @return int[]
 */
function initialise_scores($players) {
    $scores = [];
    foreach(array_keys($players) as $playerKey) {
        $scores[$playerKey] = 0;
    }
    return $scores;
}

/**
 * Creates empty multi-dimensional array of card values
 *
 * @param $players
 *                Player's array
 *
 * @return mixed
 *              Empty array of card values
 */
function initialise_cardValues($players) {
    $cardValues = [];
    foreach(array_keys($players) as $playerKey) {
        $cardValues[$playerKey] = [];
    }
    return $cardValues;
}

/**
 * Adds card value to player's score
 *
 * @param int    $score
 *                     Player's current score
 * @param array  $deck
 *                    Deck array
 * @param string $card
 *                    Selected card key
 *
 * @return int|mixed
 *                  Returns new score
 */
function increase_score(int $score, array $deck, string $card) :int {
    return $score + $deck[$card]['value'];
}

/**
 * Reduces a player's score by 10 for each ace they hold, whilst their score is over 21
 *
 * @param $score
 *              Player's score
 * @param $cards
 *              Player's dealt cards array
 * @return int
 *            Returns player's new score
 */
function check_for_aces(int $score, array $cards) {

    if (null !== array_search(11, $cards)) {
        $aceCount = count(array_keys($cards, 11, true));
        for ($i = 0; $i < $aceCount; $i++) {
            $score -= 10;
            if ($score <= 21) {
                return $score;
            }
        }
    }
    return $score;
}

/**
 * Checks relative scores and displays the winner
 *
 * @param $p1score
 *                Score for player 1
 * @param $p2score
 *                Score for player 2
 */
function get_winner($p1score, $p2score) {
    if ($p1score > 21 && $p2score > 21) {
        echo 'Both players lose!';
    } else if ($p1score <= 21 && $p2score > 21) {
        echo 'Player 1 wins!';
    } else if ($p1score > 21 && $p2score <= 21) {
        echo 'Player 2 wins!';
    } else if ($p1score === $p2score) {
        echo 'Draw!';
    } else if ($p1score > $p2score) {
        echo 'Player 1 wins!';
    } else if ($p1score < $p2score) {
        echo 'Player 2 wins!';
    }
}

// Performed on selection of deal button
if (isset($_POST['deal'])) {
    // Builds deck
    $deck = build_deck($suits, $values);
    // Initialise scores and card values
    $scores = initialise_scores($players);
    $cardValues = initialise_cardValues($players);
    while (true) {
        foreach ($players as $player) {
            // Identify player key for use in other arrays
            $playerKey = array_search($player, $players);
            // Deal one card
            $cardSelected = array_rand($deck);
            // Add card value to score
            $scores[$playerKey] = increase_score($scores[$playerKey], $deck, $cardSelected);
            // Store selected card value for player
            array_push($cardValues[$playerKey],$deck[$cardSelected]);
            // Store card key for image reference
            $cards[] = $cardSelected;
            // Remove selected card from deck
            unset($deck[$cardSelected]);
            // Check if score can be reduced
            if ($scores[$playerKey] > 21) {
                $scores[$playerKey] = check_for_aces($scores[$playerKey], $cardValues[$playerKey]);
            }
        }
        // Stops game when either player reaches 18
        foreach ($scores as $score) {
            if ($score >= 18) {
                break 2;
            }
        }
    }
}