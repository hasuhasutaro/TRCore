<?php
namespace noahasu\TRCore\entity;

use Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\entity\Zombie;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class TRZombie extends TREntity implements TREntityInterface
{
	public static function getNetworkTypeId() : string{ return EntityIds::ZOMBIE; }

	public function getInitialDragMultiplier() : float {
		return 0.02; // Default drag multiplier
	}

	public function getInitialGravity() : float {
		return 0.08; // Default gravity value
	}

	protected function getInitialSizeInfo() : EntitySizeInfo {
		return new EntitySizeInfo(1.8, 0.6); //TODO: eye height ??
	}

    public function getName() : string{
		return "TRZombie";
	}
}