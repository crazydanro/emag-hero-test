<?php

namespace src\Skills;

use src\Models\Npc;
use src\Settings;

/**
 * Class MagicShield
 * @package src\Skills
 */
class MagicShield extends Skill implements SkillInterface
{
    public function __construct()
    {
        $this->name = 'Magic shield';
        $this->type = Settings::NPC_STATE_DEFENDING;
        $this->luck = 20;
    }

    /**
     * @param Npc $npc
     * @return void
     */
    public function execute(Npc $npc) : void
    {
        $npc->setDamageTaken(50);
    }
}