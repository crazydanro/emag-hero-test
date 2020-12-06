<?php

namespace src\Library;

/**
 * Trait TraitLuck
 * @package src\Library
 */
trait TraitLuck
{
    /** @var int */
    protected $luck;

    /**
     * @return bool
     */
    public function isLucky() : bool
    {
        return rand(0, 99) < $this->luck;
    }

    /**
     * @return int
     */
    public function getLuck() : int
    {
        return $this->luck;
    }
}