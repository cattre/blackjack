<?php
require 'functions.php';
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Blackjack</title>
        <link rel='stylesheet' type= 'text/css' href='blackjack.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
    </head>
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
                        $deck = build_deck($suits, $values);
                        if (isset($cards)) {
                            foreach (array_keys($cards) as $key) {
                                if ($key % 2 === 0) {
                                    echo "
                                        <div class='card'>
                                            <img src='media/{$deck[$cards[$key]]['image']}' alt='{$cards[$key]}'>
                                        </div>
                                    ";
                                }
                            }
                        }
                    ?>
                </div>
                <div class='player_score'>
                    <?php
                        if (isset($scores['p1'])) {
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
                        $deck = build_deck($suits, $values);
                        if (isset($cards)) {
                            foreach (array_keys($cards) as $key) {
                                if ($key % 2 !== 0) {
                                    echo "
                                        <div class='card'>
                                            <img src='media/{$deck[$cards[$key]]['image']}' alt='{$cards[$key]}'>
                                        </div>
                                    ";
                                }
                            }
                        }
                    ?>
                </div>
                <div class='player_score'>
                    <?php
                    if (isset($scores['p2'])) {
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
                    if (!empty($cards) && isset($scores)) {
                        get_winner($scores['p1'], $scores['p2']);
                    }
                ?>
            </h1>
        </div>
    </body>
</html>