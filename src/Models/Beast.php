<?php

namespace src\Models;

use src\Settings;

/**
 * Class Beast
 * @package src\Models
 */
class Beast extends Npc
{
    const DEFAULT_NAME = 'Beast';

    /**
     * Hero constructor.
     * @param string|null $name
     * @param array|null $stats
     * @throws \Exception
     */
    public function __construct(string $name = null, array $stats = null)
    {
        $this->name = is_null($name) ? self::DEFAULT_NAME : $name;

        $this->setFaction(Settings::NPC_FACTION_BEAST);
        $this->setStats(is_null($stats) ? Settings::BEAST_RANGE_STATS : $stats);

        parent::__construct();
    }
}