<?php

namespace src\Models;

use src\Library\Output;
use src\Library\TraitLuck;
use src\Settings;
use src\Skills\Skill;

/**
 * Class Npc
 * @package src\Models
 */
class Npc
{
    use TraitLuck;

    /** @var string */
    protected $faction;

    /** @var string */
    protected $name;

    /** @var int */
    protected $health;

    /** @var int */
    protected $strength;

    /** @var int */
    protected $defence;

    /** @var int */
    protected $speed;

    /** @var string */
    protected $state;

    /**
     * Array of NPC skills
     * @var Skill[]
     */
    protected $skills = [];

    /**
     * Number of attacks that NPC will make to defender
     * @var int
     */
    protected $attackNo = Settings::DEFAULT_ATTACK_NO;

    /**
     * Percent of damage taken by NPC from attacker
     * @var int
     */
    protected $damageTaken = Settings::DEFAULT_DAMAGE_TAKEN;

    public function __construct()
    {
        Output::write("New NPC [{$this->name}] added for faction [{$this->faction}] and has next attributes:");
        Output::write("Health - {$this->health}");
        Output::write("Strength - {$this->strength}");
        Output::write("Defence - {$this->defence}");
        Output::write("Speed - {$this->speed}");
        Output::write("Luck - {$this->luck}");
    }

    /**
     * @param array $stats
     * @throws \Exception
     */
    protected function setStats(array $stats)
    {
        $this->health = $this->getRandomValueFor($stats,'health');
        $this->strength = $this->getRandomValueFor($stats, 'strength');
        $this->defence = $this->getRandomValueFor($stats, 'defence');
        $this->speed = $this->getRandomValueFor($stats, 'speed');
        $this->luck = $this->getRandomValueFor($stats, 'luck');
    }

    /**
     * @param array $array
     * @param string $statName
     * @return int
     * @throws \Exception
     */
    private function getRandomValueFor(array $array, string $statName) : int
    {
        if(!isset($array[$statName])) {
            throw new \Exception("Invalid stat name!");
        }

        $stat = $array[$statName];

        if(!is_array($stat) || count($stat)!= 2 || !isset($stat[0]) || !isset($stat[1])) {
            throw new \Exception("Invalid stat format!");
        }

        $min = $stat[0];
        $max = $stat[1];

        if(!is_int($min) || !is_int($max)) {
            throw new \Exception("Invalid stat values, values must be integer!");
        }

        if($min > $max) {
            throw new \Exception("Invalid stat values, max value must be equal or higher then min value!");
        }

        return rand($min, $max);
    }

    /**
     * @param Skill $skill
     */
    protected function assignSkill(Skill $skill)
    {
        $this->skills[] = $skill;
    }

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
    public function getFaction() : string
    {
        return $this->faction;
    }

    /**
     * @return int
     */
    public function getHealth() : int
    {
        return $this->health;
    }

    /**
     * @return int
     */
    public function getStrength() : int
    {
        return $this->strength;
    }

    /**
     * @return int
     */
    public function getDefence() : int
    {
        return $this->defence;
    }

    /**
     * @return int
     */
    public function getSpeed() : int
    {
        return $this->speed;
    }

    /**
     * @return string|null
     */
    public function getState() : ?string
    {
        return $this->state;
    }

    /**
     * @param string $value
     */
    public function setSpeed(string $value)
    {
        $this->speed = $value;
    }

    /**
     * @param string $value
     */
    public function setLuck(string $value)
    {
        $this->luck = $value;
    }

    /**
     * @param string $value
     */
    public function setState(string $value)
    {
        $this->state = $value;
    }

    /**
     * @param string $value
     */
    public function setFaction(string $value)
    {
        $this->faction = $value;
    }

    public function resetState()
    {
        $this->state = null;
    }

    /**
     * @param int $value
     */
    public function setAttackNo(int $value)
    {
        $this->attackNo = $value;
    }

    /**
     * @param int $value
     */
    public function setDamageTaken(int $value)
    {
        $this->damageTaken = $value;
    }

    /**
     * @param Npc $defender
     */
    public function attack(Npc $defender)
    {
        $this->applySkills();
        $defender->applySkills();

        for ($attackNo = 1;  $attackNo <= $this->attackNo; $attackNo++) {
            $defender->takeDamage($this);
        }

        $this->resetSkillsPower();
        $defender->resetSkillsPower();
    }

    /**
     * @param Npc $attacker
     */
    public function takeDamage(Npc $attacker)
    {
        $damage = ($attacker->strength - $this->defence) / (100 / $this->damageTaken);

        if(!$this->isLucky()) {
            $initHealth = $this->health;
            $this->health -= $damage;
            Output::write("Defender [{$this->name}] with [{$initHealth}] health takes [{$damage}] damage from [{$attacker->name}], remains with [{$this->health}] health");
        }else{
            Output::write("Defender [{$this->name}] with [{$this->health}] health gets lucky and dodge [{$damage}] damage from [{$attacker->name}]");
        }
    }

    protected function applySkills()
    {
        $skills = $this->getSkillsFor($this->state);

        foreach ($skills as $skill) {
            if($skill->isLucky()) {
                Output::write("[{$this->name}] gets lucky and execute [{$skill->getName()}]");
                $skill->execute($this);
            }
        }
    }

    public function resetSkillsPower()
    {
        $this->setAttackNo(Settings::DEFAULT_ATTACK_NO);
        $this->setDamageTaken(Settings::DEFAULT_DAMAGE_TAKEN);
    }

    /**
     * @param string $search
     * @return Skill[]
     */
    protected function getSkillsFor(string $search) : array
    {
        return array_filter(
            $this->skills,
            function (Skill $skill) use ($search) {
                return $skill->getType() === $search;
            }
        );
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return $this->health <= 0;
    }
}