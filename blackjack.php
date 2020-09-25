<?php
require 'functions.php';
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Blackjack</title>
        <link rel='stylesheet' type= 'text/css' href='blackjack.css'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta charset='UTF-8'>
    </head>
    <body>
        <form method='post'>
            <label>Players <select name='players'>
                <?php if (isset($numPlayers) && isset($allowedPlayers)) {
                    foreach ($allowedPlayers as $playerNum) {
                        if ($numPlayers == $playerNum) {
                            echo "<option selected='selected' value=$playerNum>$playerNum</option>";
                        } else {
                            echo "<option value=$playerNum>$playerNum</option>";
                        }
                    }
                } ?>
            </select></label>
            <input id='button' type='submit' name='deal' value='Deal'>
        </form>
        <?php if(isset($players)) { ?>
        <div id='container'>
            <?php
                    foreach (array_keys($players) as $playerKey):
            ?>
            <div class='player'>
                <h1><?php $players[$playerKey] ?></h1>
                <div class='card_container'>
                    <?php
                        // Creates div with image for even keys in selected cards array
                        if (isset($suits) && isset($values)) {
                            $deck = build_deck($suits, $values);
                        }
                        if (isset($cards) && isset($deck)) {
                            foreach ($cards[$playerKey]['images'] as $card) {
                                    echo "
                                        <div class='card'>
                                            <img src='media/{$card}' alt='{$card}'>
                                        </div>
                                    ";
                                }
                            }
                    ?>
                </div>
                <div class='player_score'>
                    <?php
                        if (isset($scores)) {
                            echo "<h2>Score: $scores[$playerKey]</h2>";
                        }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php } ?>
        <div id='winner'>
            <h1>
                <?php
                    // Runs winner function if cards have been dealt
                    if (!empty($cards) && isset($scores) && isset($players)) {
                        echo get_winner($players, $scores);
                    }
                ?>
            </h1>
        </div>
    </body>
</html>