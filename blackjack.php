<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Blackjack</title>
    <link rel='stylesheet' type= 'text/css' href='blackjack.css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
</head>

<?php

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
];;

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

$player1Cards = [];
$player2Cards = [];

$player1Score = 0;
$player2Score = 0;

$cardsChosen = [];


for ($i = 0; $i < 4; $i++) {
        $cardSelected = array_rand($deck);
        if ($i % 2 === 0) {
//            echo "Player 1 card: $cardSelected (value $deck[$cardSelected])<br>";
            $player1Score += $deck[$cardSelected];
            $player1Cards[] = $deck[$cardSelected];
            $cardsChosen[] = $cardSelected;
        } else {
//            echo "Player 2 card: $cardSelected (value $deck[$cardSelected])<br>";
            $player2Score += $deck[$cardSelected];
            $player2Cards[] = $deck[$cardSelected];
            $cardsChosen[] = $cardSelected;
        }
        array_splice($deck, intval($cardSelected), 1);
}

if ($player1Score < 14) {
    $cardSelected = array_rand($deck);
//    echo "Player 1 card: $cardSelected (value $deck[$cardSelected])<br>";
    $player1Score += $deck[$cardSelected];
    $player1Cards[] = $deck[$cardSelected];
    $cardsChosen[] = $cardSelected;
    array_splice($deck, intval($cardSelected), 1);
}

if ($player2Score < 14) {
    $cardSelected = array_rand($deck);
//    echo "Player 2 card: $cardSelected (value $deck[$cardSelected])<br>";
    $player2Score += $deck[$cardSelected];
    $player2Cards[] = $deck[$cardSelected];
    $cardsChosen[] = $cardSelected;
    array_splice($deck, intval($cardSelected), 1);
}

if ($player1Score > 21) {
    if (null !== array_search(11, $player1Cards)) {
        $player1Score -= 10;
    }
}

if ($player2Score > 21) {
    if (null !== array_search(11, $player2Cards)) {
        $player2Score -= 10;
    }
}

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

?>

<body>
    <div id='container'>
        <div class='player'>
            <h1>Player 1</h1>
            <div class='card_container'>
                <div class='card'>
                    <img src='media/<?php echo $images[$cardsChosen[0]];?>' alt='$cardsChosen[0]'>
                </div>
                <div class='card'>
                    <img src='media/<?php echo $images[$cardsChosen[2]];?>' alt='$cardsChosen[0]'>
                </div>
                <div class='card'>
                    <?php if (array_key_exists(4, $cardsChosen)) {
                        echo "<img src='media/{$images[$cardsChosen[4]]}' alt='{$cardsChosen[4]}'>";
                    }?>
                </div>
            </div>
        </div>
        <div class='player'>
            <h1>Player 2</h1>
            <div class='card_container'>
                <div class='card'>
                    <img src='media/<?php echo $images[$cardsChosen[1]];?>'>
                </div>
                <div class='card'>
                    <img src='media/<?php echo $images[$cardsChosen[3]];?>'>
                </div>
                <div class='card'>
                    <?php if (array_key_exists(5, $cardsChosen)) {
                        echo "<img src='media/{$images[$cardsChosen[5]]}' alt='{$cardsChosen[5]}'>";
                    }?>
                </div>
            </div>
        </div>
    </div>
    <div>
        <forn action
    </div>
    <div id='winner'>
        <h1>
            <?php
    //              echo "Player 1 score: $player1Score<br>";
    //              echo "Player 2 score: $player2Score<br>";
    //              echo "<br>";
                get_winner($player1Score, $player2Score);
            ?>
        </h1>
    </div>
</body>

</html>
