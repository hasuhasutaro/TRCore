<?php
namespace noahasu\TRCore\field;

use pocketmine\entity\Entity;
use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\world\World;
use noahasu\TRCore\event\field\{EnemyExitsFieldEvent, AllEnemyExitsFieldEvent};

class Field {
    /** @var string */
    private string $name;
    /** @var Entity[] */
    private array $fieldEnemies = [];
    /** @var Player[] */
    private array $fieldPlayers = [];
    /** @var World */
    private World $baseWorld;

    public function __construct(string $name, World $baseWorld) {
        $this->name = $name;
        $this->baseWorld = $baseWorld;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFieldEnemies() {
        return $this->fieldEnemies;
    }

    public function getFieldPlayers() {
        return $this->fieldPlayers;
    }

    public function getBaseWorld(): World {
        return $this->baseWorld;
    }

    public function addFieldEnemy(Entity $enemy) {
        $this->fieldEnemies[$enemy->getId()] = $enemy;
    }

    public function addFieldPlayer(Player $player) {
        $this->fieldPlayers[$player->getId()] = $player;
    }

    public function removeFieldEnemy(Entity $enemy) {
        unset($this->fieldEnemies[$enemy->getId()]);
    }

    public function removeFieldPlayer(Player $player) {
        unset($this->fieldPlayers[$player->getId()]);
    }

    public function isPlayerInField(Player $player): bool {
        return isset($this->fieldPlayers[$player->getId()]);
    }

    public function isEnemyInField(Entity $enemy): bool {
        return isset($this->fieldEnemies[$enemy->getId()]);
    }

    /**
     * プレイヤーがフィールドから退出する際に呼び出されるメソッド
     * 
     * @param Player $player
     * @param Position $teleport 退出時のテレポート先
     * @return void
     */
    public function playerExitsField(Player $player, Position $teleport): void {
        if ($this->isPlayerInField($player)) {
            $this->removeFieldPlayer($player);
            $player->teleport($teleport, $player->getLocation()->getYaw(), $player->getLocation()->getPitch());
        }

        foreach($this->fieldEnemies as $enemy) {
            $enemy->despawnFrom($player);
        }
    }

    /**
     * 敵がフィールドから退出する際に呼び出されるメソッド
     * 
     * @param Entity $enemy
     * @return void
     */
    public function enemyExitsField(Entity $enemy): void {
        if (isset($this->fieldEnemies[$enemy->getId()])) {
            $this->removeFieldEnemy($enemy);

            foreach($this->fieldPlayers as $player) {
                $enemy->despawnFrom($player);
            }
        }

        $ev = new EnemyExitsFieldEvent($enemy, $this);
        $ev->call();

        if (!$this->hasEnemy()) {
            $ev = new AllEnemyExitsFieldEvent($this);
            $ev->call();
        }
    }

    public function hasEnemy(): bool {
        return count($this->fieldEnemies) === 0;
    }

    public function clear() {
        $this->fieldEnemies = [];
        $this->fieldPlayers = [];
    }
}