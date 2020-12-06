<?php

namespace src\Skills;

use src\Library\TraitLuck;
use src\Models\Npc;

/**
 * Class Skill
 * @package src\Skills
 *
 * @method execute(Npc $npc)
 */
class Skill
{
    use TraitLuck;

    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }
}