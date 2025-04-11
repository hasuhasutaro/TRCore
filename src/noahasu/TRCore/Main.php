<?php
namespace noahasu\TRCore;

use noahasu\TRCore\command\CreateFieldCommand;
use noahasu\TRCore\command\ChangeFieldCommand;
use noahasu\TRCore\command\SpawnEntityToFieldCommand;
use noahasu\TRCore\entity\TRZombie;
use noahasu\TRCore\field\FieldManager;
use noahasu\TRCore\player\TRPlayer;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use noahasu\TRCore\field\Field;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Location;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

class Main extends PluginBase implements Listener
{
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $field = new Field("test", $this->getServer()->getWorldManager()->getDefaultWorld());
        FieldManager::getInstance()->addField($field);

        $this->getServer()->getCommandMap()->register("createfield", new CreateFieldCommand());
        $this->getServer()->getCommandMap()->register("changefield", new ChangeFieldCommand());
        $this->getServer()->getCommandMap()->register("spawntf", new SpawnEntityToFieldCommand());
    }

    public function registerEntities(): void
    {
        EntityFactory::getInstance()->register(TRZombie::class, function(World $world, CompoundTag $nbt) {
            return new TRZombie(EntityDataHelper::parseLocation($nbt, $world), $nbt);
        }, ["TRZombie"]);
    }

    public function onPlayerCreation(PlayerCreationEvent $event): void
    {
        $event->setPlayerClass(TRPlayer::class);
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        if ($player instanceof TRPlayer) {
            $players = $this->getServer()->getOnlinePlayers();
            foreach($players as $p) {
                if (!$p instanceof TRPlayer) {
                    continue;
                }

                if($p->isInField()) $p->hidePlayer($player);
            }
        }
    }

    public function onDisable(): void
    {
    }
}