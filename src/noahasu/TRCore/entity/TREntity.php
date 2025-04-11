<?php
namespace noahasu\TRCore\entity;

use noahasu\TRCore\field\Field;
use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\player\Player;

abstract class TREntity extends Entity implements TREntityInterface {
    use TREntityTrait;
}