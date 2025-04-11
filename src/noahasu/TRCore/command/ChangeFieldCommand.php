<?php
namespace noahasu\TRCore\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use noahasu\TRCore\player\TRPlayer;
use noahasu\TRCore\field\Field;
use noahasu\TRCore\field\FieldManager;

class ChangeFieldCommand extends Command
{
    public function __construct()
    {
        parent::__construct("changefield", "change field command", "/changefield", ["chf"]);
        $this->setPermission('trcore.command.changefield');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$sender instanceof TRPlayer) {
            return false;
        }

        if (count($args) < 1) {
            $sender->sendMessage("Usage: /changefield <field_id>");
            return false;
        }

        $id = (int)$args[0];
        
        $field = FieldManager::getInstance()->getFieldById($id);
        if ($field === null) {
            $sender->sendMessage("Field not found.");
            return false;
        }
        $sender->setField($field);
        $sender->sendMessage("field teleported to $id.");
        return true;
    }
}