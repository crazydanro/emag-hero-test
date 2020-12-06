<?php

require 'vendor/autoload.php';

use src\Game;
use src\Models\Beast;
use src\Models\Hero;

$game = new Game();

$game->addNPC(new Hero('Orderus'));
$game->addNPC(new Beast('Beast'));

$game->start();