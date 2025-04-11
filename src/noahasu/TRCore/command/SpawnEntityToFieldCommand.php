<?php
namespace noahasu\TRCore\command;

use noahasu\TRCore\entity\TRZombie;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use noahasu\TRCore\player\TRPlayer;
use noahasu\TRCore\field\Field;
use noahasu\TRCore\field\FieldManager;

class SpawnEntityToFieldCommand extends Command
{
    public function __construct()
    {
        parent::__construct("spawntf", "spawn entity to field command", "/spawntf", ["sptf"]);
        $this->setPermission('trcore.command.spawntf');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$sender instanceof TRPlayer) {
            return false;
        }

        if (count($args) < 1) {
            $sender->sendMessage("Usage: /field <command>");
            return false;
        }

        $id = (int)$args[0];

        $field = FieldManager::getInstance()->getFieldById($id);
        if ($field === null) {
            $sender->sendMessage("Field not found.");
            return false;
        }
        $entity = new TRZombie($sender->getLocation());
        $field->enemySpawnField($entity);
        $sender->sendMessage("Entity spawned.");
        return true;
    }
}