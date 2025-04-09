<?php

namespace noahasu\TRCore\event\field;

use noahasu\TRCore\entity\BaseEntity;
use pocketmine\event\Event;
use pocketmine\player\Player;
use noahasu\TRCore\field\Field;
use pocketmine\entity\Entity;

class AllEnemyExitsFieldEvent extends Event {
    
    private Field $field;

    public function __construct(Field $field) {
        $this->field = $field;
    }

    public function getField(): Field {
        return $this->field;
    }
}