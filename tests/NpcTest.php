<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use src\Models\Beast;
use src\Models\Hero;
use src\Models\Npc;
use src\Settings;

/**
 * Class NpcTest
 * @package tests
 */
class NpcTest extends TestCase
{

    const CUSTOM_NPC_STATS = [
        'health'    => [10, 50],
        'strength'  => [10, 40],
        'defence'   => [10, 30],
        'speed'     => [10, 20],
        'luck'      => [10, 10],
    ];

    /**
     * @return void
     * @throws \Exception
     */
    public function testCustomName() : void
    {
        $customName = 'TestHeroName';

        $hero = New Hero($customName);

        $this->assertEquals($customName, $hero->getName());
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testCheckFactions() : void
    {
        $hero = New Hero();
        $this->assertEquals(Settings::NPC_FACTION_HERO, $hero->getFaction());

        $beast = New Beast();
        $this->assertEquals(Settings::NPC_FACTION_BEAST, $beast->getFaction());
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testHeroWithDefaultStatsAndCheckStatsInterval() : void
    {
        $hero = New Hero();

        $this->checkNpcStats($hero, Settings::HERO_RANGE_STATS);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testHeroWithSpecificStatsAndCheckStatsInterval() : void
    {
        $hero = New Hero(null, self::CUSTOM_NPC_STATS);

        $this->checkNpcStats($hero, self::CUSTOM_NPC_STATS);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testBeastWithDefaultStatsAndCheckStatsInterval() : void
    {
        $beast = New Beast();

        $this->checkNpcStats($beast, Settings::BEAST_RANGE_STATS);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testBeastWithSpecificStatsAndCheckStatsInterval() : void
    {
        $beast = New Beast(null, self::CUSTOM_NPC_STATS);

        $this->checkNpcStats($beast, self::CUSTOM_NPC_STATS);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testWrongStatsArray() : void
    {
        $stats = [];

        $this->expectExceptionMessage('Invalid stat name!');

        new Hero(null, $stats);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testWrongStatFormat() : void
    {
        $statsNoArray = ['health' => 123];

        $this->expectExceptionMessage('Invalid stat format!');

        new Hero(null, $statsNoArray);
    }

    /**
     * @param Npc $npc
     * @param array $stats
     */
    protected function checkNpcStats(Npc $npc, array $stats) : void
    {
        $this->assertBetweenValues($stats['health'][0], $stats['health'][1], $npc->getHealth());
        $this->assertBetweenValues($stats['strength'][0], $stats['strength'][1], $npc->getStrength());
        $this->assertBetweenValues($stats['defence'][0], $stats['defence'][1], $npc->getDefence());
        $this->assertBetweenValues($stats['speed'][0], $stats['speed'][1], $npc->getSpeed());
        $this->assertBetweenValues($stats['luck'][0], $stats['luck'][1], $npc->getLuck());
    }

    /**
     * @param int $min
     * @param int $nax
     * @param int $value
     *
     * @return void
     */
    public function assertBetweenValues(int $min, int $nax, int $value) : void
    {
        $this->assertGreaterThanOrEqual($min, $value);
        $this->assertLessThanOrEqual($nax, $value);
    }
}