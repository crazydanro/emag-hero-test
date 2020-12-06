<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use src\Game;
use src\Models\Beast;
use src\Models\Hero;
use src\Settings;

/**
 * Class GameTest
 * @package tests
 */
class GameTest extends TestCase
{

    /**
     * @return void
     */
    public function testWorldName() : void
    {
        $worldName = "Test";
        $game = new Game($worldName);

        $this->assertEquals($worldName, $game->getWorldName());
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testAddNpc() : void
    {
        $game = new Game();
        $game->addNPC(New Hero());

        $this->assertEquals(1, $game->getNpcCount());

        $game->addNPC(New Beast());
        $game->addNPC(New Beast());

        $this->assertEquals(3, $game->getNpcCount());
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testFirstToAttackSpeedDifferent() : void
    {
        $game = new Game();

        $hero = New Hero();
        $hero->setSpeed(35);
        $game->addNPC($hero);

        $beast = New Beast();
        $beast->setSpeed(30);
        $game->addNPC($beast);

        $game->setFirstToAttack();

        $firstToAttack = $game->getNpcByState(Settings::NPC_STATE_ATTACKING);

        $this->assertEquals($hero, $firstToAttack);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testFirstToAttackSpeedEqualLuckDifferent() : void
    {
        $game = new Game();

        $hero = New Hero();
        $hero->setSpeed(30);
        $hero->setLuck(30);
        $game->addNPC($hero);

        $beast = New Beast();
        $beast->setSpeed(30);
        $beast->setLuck(35);
        $game->addNPC($beast);

        $game->setFirstToAttack();

        $firstToAttack = $game->getNpcByState(Settings::NPC_STATE_ATTACKING);

        $this->assertEquals($beast, $firstToAttack);
    }
}