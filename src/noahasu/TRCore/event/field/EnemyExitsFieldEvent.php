<?php

namespace noahasu\TRCore\event\field;

use noahasu\TRCore\entity\BaseEntity;
use pocketmine\event\Event;
use pocketmine\player\Player;
use noahasu\TRCore\field\Field;
use pocketmine\entity\Entity;

class EnemyExitsFieldEvent extends Event {

    /** @var Entity&\noahasu\TRCore\entity\TREntityInterface $enemy */
    private Entity $enemy;
    private Field $field;

    /**
     * @param Entity&\noahasu\TRCore\entity\TREntityInterface $enemy
     * @param Field $field
     */
    public function __construct(Entity $enemy, Field $field) {
        $this->enemy = $enemy;
        $this->field = $field;
    }

    /**
     * @return Entity&\noahasu\TRCore\entity\TREntityInterface
     */
    public function getEnemy(): Entity {
        return $this->enemy;
    }

    /**
     * @return Field
     */
    public function getField(): Field {
        return $this->field;
    }
}