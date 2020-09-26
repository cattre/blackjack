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
    session_start();
    // Initialise players
    $numPlayers = $_POST['players'];
    $_SESSION['players'] = initialise_players($numPlayers);
    // Builds deck
    $_SESSION['deck'] = build_deck($suits, $values);
    // Initialise scores and card values
    $_SESSION['scores'] = initialise_scores($_SESSION['players']);
    $_SESSION['cards'] = initialise_cards($_SESSION['players']);
}

// Executed on selection of deal button
if (isset($_POST['deal'])) {
    $_SESSION['activePlayers'] = initialise_activePlayers($_SESSION['players']);
    for ($i = 0; $i < 2; $i++) {
        foreach (array_keys($_SESSION['players']) as $playerKey) {
            // Deal one card
            $cardSelected = array_rand($_SESSION['deck']);
            // Add card value to score
            $_SESSION['scores'][$playerKey] = increase_score($_SESSION['scores'][$playerKey], $_SESSION['deck'], $cardSelected);
            // Store selected card value for player
            array_push($_SESSION['cards'][$playerKey]['values'], $_SESSION['deck'][$cardSelected]['value']);
            // Store card image
            array_push($_SESSION['cards'][$playerKey]['images'], $_SESSION['deck'][$cardSelected]['image']);
            // Remove selected card from deck
            unset($_SESSION['deck'][$cardSelected]);
            // Check if score can be reduced
            if ($_SESSION['scores'][$playerKey] > 21) {
                $_SESSION['scores'][$playerKey] = check_for_aces($_SESSION['scores'][$playerKey], $_SESSION['cards'][$playerKey]['values']);
            }
        }
    }
}

// Twist flow
if (isset($_POST['twist'])) {
    session_start();
    // Deal one card
    $cardSelected = array_rand($_SESSION['deck']);
    // Add card value to score
    $_SESSION['scores'][$_SESSION['activePlayers'][0]] = increase_score($_SESSION['scores'][$_SESSION['activePlayers'][0]], $_SESSION['deck'], $cardSelected);
    // Store selected card value for player
    array_push($_SESSION['cards'][$_SESSION['activePlayers'][0]]['values'], $_SESSION['deck'][$cardSelected]['value']);
    // Store card image
    array_push($_SESSION['cards'][$_SESSION['activePlayers'][0]]['images'], $_SESSION['deck'][$cardSelected]['image']);
    // Check if score can be reduced
    if ($_SESSION['scores'][$_SESSION['activePlayers'][0]] > 21 && $_SESSION['deck'][$cardSelected]['value'] === 11) {
        $_SESSION['scores'][$_SESSION['activePlayers'][0]] -= 10;
    }
    // Remove selected card from deck
    unset($_SESSION['deck'][$cardSelected]);
    // Set current player as inactive
    if ($_SESSION['scores'][$_SESSION['activePlayers'][0]] >= 21) {
        array_splice($_SESSION['activePlayers'], 0, 1);
    }
    // Run winner function if no more active players
    if (count($_SESSION['activePlayers']) === 0) {
        $winner = get_winner($_SESSION['players'], $_SESSION['scores']);
    }
}

// Stick flow
if (isset($_POST['stick'])) {
    session_start();
    // Set current player as inactive
    array_splice($_SESSION['activePlayers'], 0, 1);
    // Run winner function if no more active players
    if (count($_SESSION['activePlayers']) === 0) {
        $winner = get_winner($_SESSION['players'], $_SESSION['scores']);
    }
}

// Executed on selection of quick deal button
if (isset($_POST['quickDeal'])) {
    while (true) {
        foreach (array_keys($_SESSION['players']) as $playerKey) {
            // Deal one card
            $cardSelected = array_rand($_SESSION['deck']);
            // Add card value to score
            $scores[$playerKey] = increase_score($_SESSION['scores'][$playerKey], $_SESSION['deck'], $cardSelected);
            // Store selected card value for player
            array_push($_SESSION['cards'][$playerKey]['values'], $_SESSION['deck'][$cardSelected]['value']);
            // Store card image
            array_push($_SESSION['cards'][$playerKey]['images'], $_SESSION['deck'][$cardSelected]['image']);
            // Remove selected card from deck
            unset($_SESSION['deck'][$cardSelected]);
            // Check if score can be reduced
            if ($_SESSION['scores'][$playerKey] > 21) {
                $_SESSION['scores'][$playerKey] = check_for_aces($_SESSION['scores'][$playerKey], $_SESSION['cards'][$playerKey]['values']);
            }
            // Stops game when either player reaches 18
            foreach ($_SESSION['scores'] as $score) {
                if ($score >= 18) {
                    break 3;
                }
            }
        }
    }
    // Runs winner function
    $winner = get_winner($_SESSION['players'], $_SESSION['scores']);
}