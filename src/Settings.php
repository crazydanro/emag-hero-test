<?php

namespace src;

/**
 * Class Settings
 * @package src
 */
class Settings
{
    /** @var string */
    const DEFAULT_WORLD_NAME    = 'eMAGia';

    /** @var int */
    const MAX_ROUNDS            = 20;

    /** @var int */
    const DEFAULT_ATTACK_NO     = 1;

    /** @var int */
    const DEFAULT_DAMAGE_TAKEN  = 100;

    /** @var string */
    const NPC_FACTION_HERO      = 'hero';

    /** @var string */
    const NPC_FACTION_BEAST     = 'beast';

    /** @var string */
    const NPC_STATE_ATTACKING   = 'attacking';

    /** @var string */
    const NPC_STATE_DEFENDING   = 'defending';

    /** @var array */
    const HERO_RANGE_STATS      = [
        'health'    => [70, 100],
        'strength'  => [70, 80],
        'defence'   => [45, 55],
        'speed'     => [40, 50],
        'luck'      => [10, 30],
    ];

    /** @var array */
    const BEAST_RANGE_STATS     = [
        'health'    => [60, 90],
        'strength'  => [60, 90],
        'defence'   => [40, 60],
        'speed'     => [40, 60],
        'luck'      => [25, 40],
    ];
}