<?php
namespace noahasu\TRCore\entity;

use noahasu\TRCore\field\Field;
use pocketmine\player\Player;


interface TREntityInterface
{
    public function getField(): ?Field;
    public function setField(?Field $field): void;
    public function hasField(): bool;
    public function isInField(): bool;
    public function spawnTo(Player $player): void;
}