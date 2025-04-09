<?php
namespace noahasu\TRCore\player;

use noahasu\TRCore\field\Field;
use pocketmine\player\Player;

class TRPlayer extends Player {
    /** @var ?Field */
    private ?Field $field = null;

    public function setField(Field $field): void {
        $this->field = $field;
    }

    public function getField(): Field {
        return $this->field;
    }

    public function isInField(): bool {
        return $this->field !== null;
    }

    public function spawnTo(Player $player): void
    {
        if (!$this->isInField()) {
            parent::spawnTo($player);
            return;
        }

        if ($this->isAlive() && $this->field->isPlayerInField($player)) {
            parent::spawnTo($player);
            return;
        }
    }
}