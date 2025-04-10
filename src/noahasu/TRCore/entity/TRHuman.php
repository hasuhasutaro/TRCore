<?php
namespace noahasu\TRCore\entity;

use noahasu\TRCore\field\Field;
use pocketmine\entity\Location;
use pocketmine\player\Player;
use pocketmine\entity\Human;

class TRHuman extends Human implements TREntityInterface {
    use TREntityTrait;
    
    public function __construct(Field $field, Location $location) {
        parent::__construct($location);
        $this->field = $field;
    }
}