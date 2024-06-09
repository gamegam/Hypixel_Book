<?php

namespace gamegam\WorldGuardPlugin\EvnetListener\WorldGuardEvent;

use gamegam\WorldGuardPlugin\Data\GuarddData;
use gamegam\WorldGuardPlugin\Main;
use gamegam\WorldGuardPlugin\WorldData;
use gamegam\WorldGuardPlugin\WorldGuard;
use pocketmine\entity\object\Painting;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Entity implements Listener{

	public Main $api;
	public $tag;

	public function __construct(Main $api){
		$this->tag = WorldGuard::getInstance()->getTag();
		$this->api = $api;
	}

	public function MobSpawn(EntitySpawnEvent $ev){
		$pos = $ev->getEntity()->getPosition();
		$guardData = GuarddData::getInstance();
		$guard = WorldData::getInstance();
		if ($guard->getBlockJoin($pos)){
			if ($guardData->getMobSpawn($guard->getName($pos))){
				if (! $ev->getEntity() instanceof Player && ! $ev->getEntity() instanceof Painting){
					$ev->getEntity()->teleport(new Vector3(0, -99, 0));
					$ev->getEntity()->flagForDespawn();
				}
			}
		}
	}
}