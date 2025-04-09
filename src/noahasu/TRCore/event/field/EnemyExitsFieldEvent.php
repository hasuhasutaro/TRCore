<?php

namespace noahasu\TRCore\event\field;

use noahasu\TRCore\entity\BaseEntity;
use pocketmine\event\Event;
use pocketmine\player\Player;
use noahasu\TRCore\field\Field;
use pocketmine\entity\Entity;

class EnemyExitsFieldEvent extends Event {

    private BaseEntity $enemy;
    private Field $field;

    public function __construct(BaseEntity $enemy, Field $field) {
        $this->enemy = $enemy;
        $this->field = $field;
    }

    public function getEnemy(): BaseEntity {
        return $this->enemy;
    }

    public function getField(): Field {
        return $this->field;
    }
}