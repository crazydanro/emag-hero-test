<?php

namespace src\Skills;

use src\Models\Npc;
use src\Settings;

/**
 * Class RapidStrike
 * @package src\Skills
 */
class RapidStrike extends Skill implements SkillInterface
{
    public function __construct()
    {
        $this->name = 'Rapid strike';
        $this->type = Settings::NPC_STATE_ATTACKING;
        $this->luck = 10;
    }

    /**
     * @param Npc $npc
     * @return void
     */
    public function execute(Npc $npc) : void
    {
        $npc->setAttackNo(2);
    }
}