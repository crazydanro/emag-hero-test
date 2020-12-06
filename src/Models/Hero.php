<?php

namespace src\Models;

use src\Settings;
use src\Skills\MagicShield;
use src\Skills\RapidStrike;

/**
 * Class Hero
 * @package src\Models
 */
class Hero extends Npc
{
    const DEFAULT_NAME = 'Hero';

    /**
     * Hero constructor.
     * @param string|null $name
     * @param array|null $stats
     * @throws \Exception
     */
    public function __construct(string $name = null, array $stats = null)
    {
        $this->name = is_null($name) ? self::DEFAULT_NAME : $name;

        $this->setFaction(Settings::NPC_FACTION_HERO);
        $this->setStats(is_null($stats) ? Settings::HERO_RANGE_STATS : $stats);

        $this->assignSkill(new RapidStrike());
        $this->assignSkill(new MagicShield());

        parent::__construct();
    }
}