<?php
namespace noahasu\TRCore\entity;

use noahasu\TRCore\field\Field;
use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\player\Player;

trait TREntityTrait
{
    /** @var ?Field */
    protected ?Field $field = null;

    public function getField(): ?Field {
        return $this->field;
    }

    public function setField(?Field $field): void {
        $this->field = $field;
    }

    public function hasField(): bool {
        return isset($this->field);
    }

    public function isInField(): bool {
        return $this->field !== null;
    }

    public function spawnTo(Player $player): void {
        $player->sendMessage("prepare spawing.");
        if ($this->isAlive() && $this->field?->isPlayerInField($player) ?? false) {
            $player->sendMessage("entity spawn to you.");
            parent::spawnTo($player);
        }
    }
}