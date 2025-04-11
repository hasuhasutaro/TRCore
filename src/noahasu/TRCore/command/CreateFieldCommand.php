<?php
namespace noahasu\TRCore\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use noahasu\TRCore\player\TRPlayer;
use noahasu\TRCore\field\Field;
use noahasu\TRCore\field\FieldManager;

class CreateFieldCommand extends Command
{
    public function __construct()
    {
        parent::__construct("createfield", "create field command", "/createfield", ["crf"]);
        $this->setPermission('trcore.command.createfield');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$sender instanceof TRPlayer) {
            return false;
        }
        
        $field = new Field("test", $sender->getWorld(), $sender->getLocation());
        FieldManager::getInstance()->addField($field);
        $id = $field->getId();
        $sender->sendMessage("Field created with ID: $id");
        return true;
    }
}