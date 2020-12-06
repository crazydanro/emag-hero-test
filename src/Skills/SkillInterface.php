<?php

namespace src\Skills;

use src\Models\Npc;

/**
 * Interface SkillInterface
 * @package src\Skills
 */
interface SkillInterface
{
    public function execute(Npc $npc) : void;
}