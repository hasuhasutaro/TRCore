<?php
namespace noahasu\TRCore\entity;

use noahasu\TRCore\field\Field;
use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\player\Player;

abstract class BaseEntity extends Entity {
    /** @var ?Field */
    protected ?Field $field = null;

    public function __construct(Field $field, Location $location) {
        parent::__construct($location);
        $this->field = $field;
    }

    public function getField(): ?Field {
        return $this->field;
    }

    public function setField(?Field $field): void {
        $this->field = $field;
    }

    public function hasField(): bool {
        return isset($this->field);
    }

    public function spawnTo(Player $player): void
    {
        if ($this->isAlive() && $this->field->isPlayerInField($player)) {
            parent::spawnTo($player);
        }
    }
}