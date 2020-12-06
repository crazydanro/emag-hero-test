<?php

namespace src;

use src\Library\Output;
use src\Models\Npc;

/**
 * Class Game
 * @package src
 */
class Game
{
    /** @var string */
    protected $worldName;

    /** @var Npc[] */
    protected $npc;

    /** @var int */
    protected $round;

    /** @var Npc */
    protected $winner;

    /**
     * Game constructor.
     * @param string|null $worldName
     */
    public function __construct(string $worldName = null)
    {
        $this->worldName = is_null($worldName) ? Settings::DEFAULT_WORLD_NAME : $worldName;

        Output::write("World [{$this->worldName}] has been started!");
    }

    /**
     * @return void
     */
    public function start() : void
    {
        if(count($this->npc) < 2 || (is_null($this->getNpcByType(Settings::NPC_FACTION_HERO)) || is_null($this->getNpcByType(Settings::NPC_FACTION_BEAST)))) {
            Output::write("You dont have at least 1 NPC for each faction, game ended!");

            return;
        }

        $this->setFirstToAttack();
        $this->battle();
    }

    /**
     * @param Npc $npc
     * @return void
     */
    public function addNPC(Npc $npc) : void
    {
        $this->npc[] = $npc;
    }

    /**
     * @return void
     */
    public function setFirstToAttack() : void
    {
        usort(
            $this->npc,
            function (Npc $object1, Npc $object2) {
                if($object1->getSpeed() === $object2->getSpeed()) {
                    return $object1->getLuck() < $object2->getLuck();
                }

                return $object1->getSpeed() < $object2->getSpeed();
            }
        );

        $attacker = $this->npc[0];
        $attacker->setState(Settings::NPC_STATE_ATTACKING);

        Output::write("[{$attacker->getName()}] will attack first.");

        $defenderType = $attacker->getFaction() === Settings::NPC_FACTION_HERO ? Settings::NPC_FACTION_BEAST : Settings::NPC_FACTION_HERO;

        $defender = $this->getNpcByType($defenderType);
        $defender->setState(Settings::NPC_STATE_DEFENDING);
    }

    /**
     * @return void
     */
    protected function battle() : void
    {
        for($this->round = 1; $this->round <= Settings::MAX_ROUNDS; $this->round++) {
            Output::write("Round {$this->round} starts!");

            $attacker = $this->getNpcByState(Settings::NPC_STATE_ATTACKING);
            $defender = $this->getNpcByState(Settings::NPC_STATE_DEFENDING);

            $attacker->attack($defender);

            if($defender->isDead()) {
                Output::write("Defender [{$defender->getName()}] is dead!");
                $this->winner = $attacker;
                break;
            }

            $attacker->setState(Settings::NPC_STATE_DEFENDING);
            $defender->setState(Settings::NPC_STATE_ATTACKING);
        }

        if(is_null($this->winner)) {
            $this->winner = $this->getWinner([$attacker, $defender]);
        }

        Output::write("[{$this->winner->getName()}] wins!!!");
    }

    /**
     * @param string $type
     * @return Npc|null
     */
    public function getNpcByType(string $type) : ?Npc
    {
        return $this->getNpcBy('faction', $type);
    }

    /**
     * @param string $state
     * @return Npc|null
     */
    public function getNpcByState(string $state) : ?Npc
    {
        return $this->getNpcBy('state', $state);
    }

    /**
     * @param string $property
     * @param string $search
     * @return Npc|null
     */
    protected function getNpcBy(string $property, string $search) : ?Npc
    {
        $result = array_filter(
            $this->npc,
            function (Npc $npc) use ($property, $search) {
                $methodName = 'get'.ucfirst(strtolower($property));

                if(method_exists($npc, $methodName)) {
                    return $npc->$methodName() === $search;
                }else{
                    throw new \Exception("Method [{$methodName}] dose not exist!");
                }
            }
        );

        return !empty($result) ? $this->npc[array_key_first($result)] : null;
    }

    /**
     * @param Npc[] $npcList
     * @return Npc
     */
    protected function getWinner(array $npcList) : Npc
    {
        usort(
            $npcList,
            function (Npc $object1, Npc $object2) {
                    if($object1->getHealth() === $object2->getHealth()) {
                    return $object1->getLuck() < $object2->getLuck();
                }

                return $object1->getHealth() < $object2->getHealth();
            }
        );

        return $npcList[0];
    }

    /**
     * @return string
     */
    public function getWorldName() : string
    {
        return $this->worldName;
    }

    /**
     * @return int
     */
    public function getNpcCount () : int
    {
        return count($this->npc);
    }
}