<?php
namespace noahasu\TRCore\player;

use noahasu\TRCore\field\Field;
use pocketmine\player\Player;

class TRPlayer extends Player {
    /** @var ?Field */
    private ?Field $field = null;

    public function setField(?Field $field): void {
        if ($this?->isInField() ?? false) {
            $this->field->playerExitsField($this);
        }

        $this->field = $field;

        if (isset($field)) {
            $field->playerSpawnField($this);
        }
    }

    public function getField(): Field {
        return $this->field;
    }

    public function isInField(): bool {
        return $this->field !== null;
    }
}