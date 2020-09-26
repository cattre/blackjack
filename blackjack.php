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
        <form id='dealButtons' method='post'>
            <label id='playersSelect'>Players<select name='players'>
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
            <input id='deal' type='submit' name='deal' value='Deal'>
            <input id='quickDeal' type='submit' name='quickDeal' value='Quick Deal!'>
        </form>
        <?php if(isset($_SESSION['players'])) { ?>
        <div id='container'>
            <?php
                    foreach (array_keys($_SESSION['players']) as $playerKey):
            ?>
            <div class='player'>
                <h1><?php $_SESSION['players'][$playerKey] ?></h1>
                <div class='cardContainer'>
                    <?php
                        // Creates div with image for even keys in selected cards array
                        if (isset($suits) && isset($values)) {
                            $newDeck = build_deck($suits, $values);
                        }
                        if (isset($_SESSION['cards']) && isset($newDeck)) {
                            foreach ($_SESSION['cards'][$playerKey]['images'] as $card) {
                                    echo "
                                        <div class='card'>
                                            <img src='media/{$card}' alt='{$card}'>
                                        </div>
                                    ";
                                }
                            }
                    ?>
                </div>
                <div class='playerScore'>
                    <?php
                        if (isset($_SESSION['scores'])) {
                            echo "<h2>Score: {$_SESSION['scores'][$playerKey]}</h2>";
                        }
                    ?>
                </div>
                <div>
                    <?php if (!empty($_SESSION['activePlayers']) && $_SESSION['activePlayers'][0] === $playerKey) { ?>
                        <form id=stickTwist method='post'>
                            <input id='stick' type='submit' name='stick' value='Stick'>
                            <input id='twist' type='submit' name='twist' value='Twist'>
                        </form>
                    <?php } ?>
                </div>
                <div>
                    <?php if ($_SESSION['scores'][$playerKey] > 21)
                        echo "<h1>Bust!</h1>";
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php } ?>
        <div id='winner'>
            <h1>
                <?php
                    if(isset($winner)) {
                        echo $winner;
                    }
                ?>
            </h1>
        </div>
    </body>
</html>