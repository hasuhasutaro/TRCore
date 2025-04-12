<?php
namespace noahasu\TRCore\field;

use pocketmine\entity\Entity;
use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\world\World;
use noahasu\TRCore\event\field\{EnemyExitsFieldEvent, AllEnemyExitsFieldEvent};
use noahasu\TRCore\player\TRPlayer;

class Field {
    /** @var int */
    private static int $nextId = 0;

    /** @var int */
    private string $id;
    /** @var string */
    private string $name;
    /** @var Entity&\noahasu\TRCore\entity\TREntityInterface $enemy[] */
    private array $fieldEnemies = [];
    /** @var Player[] */
    private array $fieldPlayers = [];
    /** @var World */
    private World $baseWorld;

    public function __construct(string $name, World $baseWorld) {
        $this->name = $name;
        $this->baseWorld = $baseWorld;
        $this->id = $this->getNextId();
    }

    private function getNextId(): int {
        return self::$nextId++;
    }

    public function getId(): int {
        return $this->id;
    }
    
    public function getFieldName(): string {
        return $this->name;
    }

    /**
     * フィールドにプレイヤーがスポーンする際に呼び出されるメソッド
     * Player.setField()を呼び出すことで、フィールドにスポーンすることができる。
     * 
     * @deprecated このメソッドは非推奨です。TRPlayer.setField()を使用してください。
     * @param TRPlayer $player
     * @return void
     */
    public function playerSpawnField(TRPlayer $player): void {
        if ($this->isPlayerInField($player)) {
            return;
        }

        if ($player->isInField()) {
            $player->getField()->playerExitsField($player);
        }

        $this->addFieldPlayer($player);
        
        foreach($this->fieldEnemies as $enemy) {
            $enemy->spawnTo($player);
        }

        $player->sendActionBarMessage("§aフィールドにスポーンしました！");
    }

    /**
     * フィールドに敵がスポーンする際に呼び出されるメソッド
     * 
     * @param Entity&\noahasu\TRCore\entity\TREntityInterface $enemy
     * @return void
     */
    public function enemySpawnField(Entity $enemy): void {
        if ($this->isEnemyInField($enemy)) {
            return;
        }

        $this->addFieldEnemy($enemy);
        $enemy->setField($this);

        foreach($this->fieldPlayers as $player) {
            $player->sendActionBarMessage("§aフィールドに敵がスポーンしました！");
            $enemy->spawnTo($player);
        }
    }

    /**
     * プレイヤーがフィールドから退出する際に呼び出されるメソッド
     * 
     * @param Player $player
     * @param Position $teleport 退出時のテレポート先
     * @return void
     */
    public function playerExitsField(Player $player, ?Position $teleport = null): void {
        if ($this->isPlayerInField($player)) {
            $this->removeFieldPlayer($player);

            if (isset($position))
                $player->teleport($teleport, $player->getLocation()->getYaw(), $player->getLocation()->getPitch());
        }

        foreach($this->fieldEnemies as $enemy) {
            $enemy->despawnFrom($player);
        }

        foreach($this->fieldPlayers as $p) {
            $p->hidePlayer($player);
            $player->hidePlayer($p);
        }
    }

    /**
     * 敵がフィールドから退出する際に呼び出されるメソッド
     * 
     * @param Entity&\noahasu\TRCore\entity\TREntityInterface $enemy
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

    private function addFieldEnemy(Entity $enemy) {
        $this->fieldEnemies[$enemy->getId()] = $enemy;
    }

    private function addFieldPlayer(Player $player) {
        $this->fieldPlayers[$player->getId()] = $player;
    }

    private function removeFieldEnemy(Entity $enemy) {
        unset($this->fieldEnemies[$enemy->getId()]);
    }

    private function removeFieldPlayer(Player $player) {
        unset($this->fieldPlayers[$player->getId()]);
    }

    public function isPlayerInField(Player $player): bool {
        return isset($this->fieldPlayers[$player->getId()]);
    }

    /**
     * @param Entity&\noahasu\TRCore\entity\TREntityInterface $enemy
     * @return bool
     */
    public function isEnemyInField(Entity $enemy): bool {
        return isset($this->fieldEnemies[$enemy->getId()]);
    }

    public function hasEnemy(): bool {
        return count($this->fieldEnemies) === 0;
    }

    public function clear() {
        $this->fieldEnemies = [];
        $this->fieldPlayers = [];
    }
}