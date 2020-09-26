<?php

// Array of card images
$suits = ['Spades', 'Clubs', 'Hearts', 'Diamonds'];
$values = [
    'Ace' => 11,
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

// Default number of players
$numPlayers = 2;

$allowedPlayers = [2, 3, 4];

/**
 * Build players array based on number of players
 *
 * @param int $numPlayers
 *                       Number of players
 *
 * @return array
 *              Players array
 */
function initialise_players(int $numPlayers) :array {
    $players = [];
    for ($i = 1; $i <= $numPlayers; $i++) {
        $players["p$i"] = "Player $i";
    }
    return $players;
}

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
function initialise_scores(array $players) :array {
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
function initialise_cards(array $players) :array {
    $cards = [];
    foreach(array_keys($players) as $playerKey) {
        $cards[$playerKey] = ['images' => [], 'values' => []];
    }
    return $cards;
}

/**
 * Creates empty array to store current game status for each player
 *
 * @param array $players
 *                      Player's array
 *
 * @return array
 *              Returns stick choices array
 */
function initialise_activePlayers(array $players) :array {
    $activePlayers = [];
    foreach(array_keys($players) as $playerKey) {
        $activePlayers[] = $playerKey;
    }
    return $activePlayers;
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
 * @param $values
 *              Values array from dealt cards array
 * @return int
 *            Returns player's new score
 */
function check_for_aces(int $score, array $values) :int {

    if (null !== array_search(11, $values)) {
        $aceCount = count(array_keys($values, 11, true));
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
 * Checks relative scores to identify the winner(s)
 *
 * @param array $players
 *                      Players array
 * @param array $scores
 *                      Scores array
 *
 * @return string
 *               Returns winner in formatted string
 */
function get_winner(array $players, array $scores) :string {
    $winners = ['winningScore' => 0, 'players' => []];
    foreach (array_keys($players) as $playerKey) {
        if ($scores[$playerKey] <= 21) {
            if ($winners['winningScore'] === 0 || $scores[$playerKey] > $winners['winningScore']) {
                $winners = ['winningScore' => $scores[$playerKey], 'players' => [$playerKey]];
            } else if ($scores[$playerKey] === $winners['winningScore']) {
                array_push($winners['players'], $playerKey);
            }
        }
    }

    $numWinners = count($winners['players']);

    switch (true) {
        case empty($winners['players']) :
            return "All players lose!";
        case $numWinners === 2 && count($players) === 2 :
            return "Both players draw!";
        case $numWinners === count($players) :
            return "All players draw!";
        case $numWinners === 1 :
            return "{$players[$winners['players'][0]]} wins!";
        case $numWinners === 2 && count($players) > 2:
            return "{$players[$winners['players'][0]]} and {$players[$winners['players'][1]]} draw!";
        case $numWinners > 2 :
            $output = null;
            for ($i = 0; $i < $numWinners - 1; $i++) {
                $output = "{$players[$winners['players'][$i]]},";
            }
            return "$output, and {$players[$winners['players'][$numWinners - 1]]} all draw!";
        default :
            return "Unexpected outcome";
    }
}

// Initialise game
if (isset($_POST['deal']) || isset($_POST['quickDeal'])) {
    // Initialise players
    $numPlayers = $_POST['players'];
    $players = initialise_players($numPlayers);
    // Builds deck
    $deck = build_deck($suits, $values);
    // Initialise scores and card values
    $scores = initialise_scores($players);
    $cards = initialise_cards($players);

    // Executed on selection of deal button
    if (isset($_POST['deal'])) {
        $gameType = 'normal';
        $activePlayers = initialise_activePlayers($players);
        for ($i = 0; $i < 2; $i++) {
            foreach (array_keys($players) as $playerKey) {
                // Deal one card
                $cardSelected = array_rand($deck);
                // Add card value to score
                $scores[$playerKey] = increase_score($scores[$playerKey], $deck, $cardSelected);
                // Store selected card value for player
                array_push($cards[$playerKey]['values'], $deck[$cardSelected]['value']);
                // Store card image
                array_push($cards[$playerKey]['images'], $deck[$cardSelected]['image']);
                // Remove selected card from deck
                unset($deck[$cardSelected]);
                // Check if score can be reduced
                if ($scores[$playerKey] > 21) {
                    $scores[$playerKey] = check_for_aces($scores[$playerKey], $cards[$playerKey]['values']);
                }
            }
        }
    }

    // Executed on selection of quick deal button
    if (isset($_POST['quickDeal'])) {
        $gameType = 'quick';
        while (true) {
            foreach (array_keys($players) as $playerKey) {
                // Deal one card
                $cardSelected = array_rand($deck);
                // Add card value to score
                $scores[$playerKey] = increase_score($scores[$playerKey], $deck, $cardSelected);
                // Store selected card value for player
                array_push($cards[$playerKey]['values'], $deck[$cardSelected]['value']);
                // Store card image
                array_push($cards[$playerKey]['images'], $deck[$cardSelected]['image']);
                // Remove selected card from deck
                unset($deck[$cardSelected]);
                // Check if score can be reduced
                if ($scores[$playerKey] > 21) {
                    $scores[$playerKey] = check_for_aces($scores[$playerKey], $cards[$playerKey]['values']);
                }
            }
            // Stops game when either player reaches 18
            foreach ($scores as $score) {
                if ($score >= 18) {
                    break 2;
                }
            }
        }
        // Runs winner function
        $winner = get_winner($players, $scores);
    }
}

//        while (count($activePlayers) > 0) {
//            foreach (array_keys($players) as $playerKey) {
//                if ($activePlayers[0] === $playerKey) {
// Set stick/twist button visibility
//                    $stickTwist = true;
//                    while ($scores[$playerKey] < 21) {
// Twist flow
if (isset($_POST['twist'])) {
    // Deal one card
    $cardSelected = array_rand($deck);
    // Add card value to score
    $scores[$activePlayers[0]] = increase_score($scores[$activePlayers[0]], $deck, $cardSelected);
    // Store selected card value for player
    array_push($cards[$activePlayers[0]]['values'], $deck[$cardSelected]['value']);
    // Store card image
    array_push($cards[$activePlayers[0]]['images'], $deck[$cardSelected]['image']);
    // Remove selected card from deck
    unset($deck[$cardSelected]);
    // Check if score can be reduced
    if ($scores[$activePlayers[0]] > 21) {
        $scores[$activePlayers[0]] = check_for_aces($scores[$activePlayers[0]], $cards[$activePlayers[0]]['values']);
    }
}
// Stick flow
if (isset($_POST['stick'])) {
//                            $stickTwist = false;
    array_splice($activePlayers, array_search($playerKey, $activePlayers), 1);
}
//                    }
//                    $stickTwist = false;
//                    array_splice($activePlayers, array_search($playerKey, $activePlayers), 1);
//                } else {
//                    $stickTwist = false;
//                }
//            }
//        }
//        // Runs winner function
//        $winner = get_winner($players, $scores);
//    }