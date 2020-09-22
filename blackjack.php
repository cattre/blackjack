<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Blackjack</title>
        <link rel='stylesheet' type= 'text/css' href='blackjack.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
    </head>

<?php

// Array of card images
$images = [
    'Ace of Spades' => 'SPADE-1.svg',
    '2 of Spades' => 'SPADE-2.svg',
    '3 of Spades' => 'SPADE-3.svg',
    '4 of Spades' => 'SPADE-4.svg',
    '5 of Spades' => 'SPADE-5.svg',
    '6 of Spades' => 'SPADE-6.svg',
    '7 of Spades' => 'SPADE-7.svg',
    '8 of Spades' => 'SPADE-8.svg',
    '9 of Spades' => 'SPADE-9.svg',
    '10 of Spades' => 'SPADE-10.svg',
    'Jack of Spades' => 'SPADE-11-JACK.svg',
    'Queen of Spades' => 'SPADE-12-QUEEN.svg',
    'King of Spades' => 'SPADE-13-KING.svg',
    'Ace of Clubs' => 'CLUB-1.svg',
    '2 of Clubs' => 'CLUB-2.svg',
    '3 of Clubs' => 'CLUB-3.svg',
    '4 of Clubs' => 'CLUB-4.svg',
    '5 of Clubs' => 'CLUB-5.svg',
    '6 of Clubs' => 'CLUB-6.svg',
    '7 of Clubs' => 'CLUB-7.svg',
    '8 of Clubs' => 'CLUB-8.svg',
    '9 of Clubs' => 'CLUB-9.svg',
    '10 of Clubs' => 'CLUB-10.svg',
    'Jack of Clubs' => 'CLUB-11-JACK.svg',
    'Queen of Clubs' => 'CLUB-12-QUEEN.svg',
    'King of Clubs' => 'CLUB-13-KING.svg',
    'Ace of Hearts' => 'HEART-1.svg',
    '2 of Hearts' => 'HEART-2.svg',
    '3 of Hearts' => 'HEART-3.svg',
    '4 of Hearts' => 'HEART-4.svg',
    '5 of Hearts' => 'HEART-5.svg',
    '6 of Hearts' => 'HEART-6.svg',
    '7 of Hearts' => 'HEART-7.svg',
    '8 of Hearts' => 'HEART-8.svg',
    '9 of Hearts' => 'HEART-9.svg',
    '10 of Hearts' => 'HEART-10.svg',
    'Jack of Hearts' => 'HEART-11-JACK.svg',
    'Queen of Hearts' => 'HEART-12-QUEEN.svg',
    'King of Hearts' => 'HEART-13-KING.svg',
    'Ace of Diamonds' => 'DIAMOND-1.svg',
    '2 of Diamonds' => 'DIAMOND-2.svg',
    '3 of Diamonds' => 'DIAMOND-3.svg',
    '4 of Diamonds' => 'DIAMOND-4.svg',
    '5 of Diamonds' => 'DIAMOND-5.svg',
    '6 of Diamonds' => 'DIAMOND-6.svg',
    '7 of Diamonds' => 'DIAMOND-7.svg',
    '8 of Diamonds' => 'DIAMOND-8.svg',
    '9 of Diamonds' => 'DIAMOND-9.svg',
    '10 of Diamonds' => 'DIAMOND-10.svg',
    'Jack of Diamonds' => 'DIAMOND-11-JACK.svg',
    'Queen of Diamonds' => 'DIAMOND-12-QUEEN.svg',
    'King of Diamonds' => 'DIAMOND-13-KING.svg'
];

// Array of card values
$deck = [
    'Ace of Spades' => 11,
    '2 of Spades' => 2,
    '3 of Spades' => 3,
    '4 of Spades' => 4,
    '5 of Spades' => 5,
    '6 of Spades' => 6,
    '7 of Spades' => 7,
    '8 of Spades' => 8,
    '9 of Spades' => 9,
    '10 of Spades' => 10,
    'Jack of Spades' => 10,
    'Queen of Spades' => 10,
    'King of Spades' => 10,
    'Ace of Clubs' => 11,
    '2 of Clubs' => 2,
    '3 of Clubs' => 3,
    '4 of Clubs' => 4,
    '5 of Clubs' => 5,
    '6 of Clubs' => 6,
    '7 of Clubs' => 7,
    '8 of Clubs' => 8,
    '9 of Clubs' => 9,
    '10 of Clubs' => 10,
    'Jack of Clubs' => 10,
    'Queen of Clubs' => 10,
    'King of Clubs' => 10,
    'Ace of Hearts' => 11,
    '2 of Hearts' => 2,
    '3 of Hearts' => 3,
    '4 of Hearts' => 4,
    '5 of Hearts' => 5,
    '6 of Hearts' => 6,
    '7 of Hearts' => 7,
    '8 of Hearts' => 8,
    '9 of Hearts' => 9,
    '10 of Hearts' => 10,
    'Jack of Hearts' => 10,
    'Queen of Hearts' => 10,
    'King of Hearts' => 10,
    'Ace of Diamonds' => 11,
    '2 of Diamonds' => 2,
    '3 of Diamonds' => 3,
    '4 of Diamonds' => 4,
    '5 of Diamonds' => 5,
    '6 of Diamonds' => 6,
    '7 of Diamonds' => 7,
    '8 of Diamonds' => 8,
    '9 of Diamonds' => 9,
    '10 of Diamonds' => 10,
    'Jack of Diamonds' => 10,
    'Queen of Diamonds' => 10,
    'King of Diamonds' => 10
];

$players = ['p1' => 'Player 1', 'p2' => 'Player 2'];
$cardValues = [];
$scores = [];
$cards = [];

/**
 * @param $score
 * @param $deck
 * @param $card
 *
 * @return mixed
 */
function increase_score($score, $deck, $card) {
    // Adds card value to player's score
    return $score + $deck[$card];
}

/**
 * Removes card from deck
 *
 * @param $deck
 * @param $card
 *
 * @return array
 */
function update_deck($deck, $card) {
    return array_splice($deck, intval($card), 1);
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
function check_for_aces($score, $cards) {

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
 *                 Score for player 1
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
    // Stops game when either player reaches 18
    while (true) {
        foreach ($scores as $score) {
            if ($score > 18) {
                break;
            }
        }
        foreach ($players as $player) {
            // Identify player key for use in other arrays
            $playerKey = array_search($player, $players);
            // Initialise player score
            $scores[$playerKey] = 0;
            // Deal one card
            $cardSelected = array_rand($deck);
            // Add card to score
            $scores[$playerKey] = increase_score($scores[$playerKey], $deck, $cardSelected);
            // Store selected card value for player
            $cardValues[$playerKey] =  $deck[$cardSelected];
            // Store card key for image reference
            $cardsChosen[] = $cardSelected;
            // Remove selected card from deck
            $deck = update_deck($deck, $cardSelected);
        }
        if ($scores[$playerKey] > 21) {
            // Check if score can be reduced
            $scores[$playerKey] = check_for_aces($scores[$playerKey], $cardValues[$playerKey]);
        }
    }
}

?>

    <body>
        <form method='post'>
            <input id='button' type='submit' name='deal' value='Deal'>
        </form>
        <div id='container'>
            <div class='player'>
                <h1>Player 1</h1>
                <div class='card_container'>
                    <?php
                        // Creates div with image for even keys in selected cards array
                        foreach (array_keys($cards) as $key) {
                            if ($key % 2 === 0) {
                                echo "
                                    <div class='card'>
                                        <img src='media/{$images[$cards[$key]]}' alt='{$cards[$key]}'>
                                    </div>
                                ";
                            }
                        }
                    ?>
                </div>
                <div class='player_score'>
                    <?php
                    if ($scores['p1'] !== 0) {
                        echo "<h2>Score: $scores[p1]</h2>";
                    }
                    ?>
                </div>
            </div>
            <div class='player'>
                <h1>Player 2</h1>
                <div class='card_container'>
                    <?php
                        // Creates div with image for even keys in selected cards array
                        foreach (array_keys($cards) as $key) {
                            if ($key % 2 !== 0) {
                                echo "
                                    <div class='card'>
                                        <img src='media/{$images[$cards[$key]]}' alt='{$cards[$key]}'>
                                    </div>
                                ";
                            }
                        }
                    ?>
                </div>
                <div class='player_score'>
                    <?php
                    if ($scores['p2'] !== 0) {
                        echo "<h2>Score: $scores[p2]</h2>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id='winner'>
            <h1>
                <?php
                    // Runs winner function if cards have been dealt
                    if (!empty($cards)) {
                        get_winner($scores['p1'], $scores['p2']);
                    }
                ?>
            </h1>
        </div>
    </body>
</html>
