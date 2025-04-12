<?php
namespace noahasu\TRCore\player;

use noahasu\TRCore\field\Field;
use pocketmine\player\Player;

class TRPlayer extends Player {
    /** @var ?Field */
    private ?Field $field = null;

    public function setField(?Field $field): void {
        // 現在のフィールドから退出
        if ($this->isInField()) {
            $this->field->playerExitsField($this);
        }

        // 新しいフィールドに設定
        $this->field = $field;

        if ($field !== null) {
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