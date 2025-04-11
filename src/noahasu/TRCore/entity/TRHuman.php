<?php
namespace noahasu\TRCore\entity;

use noahasu\TRCore\field\Field;
use pocketmine\entity\Location;
use pocketmine\player\Player;
use pocketmine\entity\Human;

class TRHuman extends Human implements TREntityInterface {
    use TREntityTrait;
}