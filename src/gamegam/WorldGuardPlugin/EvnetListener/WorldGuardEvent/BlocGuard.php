<?php

namespace gamegam\WorldGuardPlugin\EvnetListener\WorldGuardEvent;

use gamegam\WorldGuardPlugin\Data\GuarddData;
use gamegam\WorldGuardPlugin\WorldData;
use gamegam\WorldGuardPlugin\WorldGuard;
use pocketmine\block\Lava;
use pocketmine\block\VanillaBlocks;
use pocketmine\block\Water;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockSpreadEvent;
use pocketmine\event\entity\EntityPreExplodeEvent;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\world\Position;

class BlocGuard implements Listener{

	public $tag, $api;

	public function __construct($api){
		$this->tag = WorldGuard::getInstance()->getTag();
		$this->api = $api;
	}

	public function Blocks(BlockSpreadEvent $ev){
		$source = $ev->getSource();
		$block = $ev->getBlock();
		$pos = $block->getPosition();
		$guardData = GuarddData::getInstance();
		$guard = WorldData::getInstance();
		if($guard->getBlockJoin($pos)){
			$name = $guard->getName($pos);
			if($guardData->getLave($name)){
				if ($source instanceof Lava){
					$ev->cancel();
				}
			}
			if ($guardData->getWater($name)){
				if ($source instanceof Water){
					$ev->cancel();
				}
			}
		}
	}

	public function onBlockBreak(BlockBreakEvent $ev){
		$p = $ev->getPlayer();
		$guardData = GuarddData::getInstance();
		$guard = WorldData::getInstance();
		$name = $guard->getName($ev->getBlock()->getPosition());
		if(! $p->hasPermission("WorldGuardPlugin.permissimon")){
			if($guard->getBlockJoin($ev->getBlock()->getPosition())){
				if($guardData->getBuild($name)){
					if(! $guardData->getMembers($name, $p->getName())){
						$p->sendMessage($this->tag . $this->api->getAPI()->getString("BlockBreak"));
						$ev->cancel();
					}
				}
			}
		}
	}

	public function onBlockP(BlockPlaceEvent $ev){
		$p = $ev->getPlayer();
		$guaraData = GuarddData::getInstance();
		$guard = WorldData::getInstance();
		$air = VanillaBlocks::AIR();
		foreach($ev->getTransaction()->getBlocks() as [$x, $y, $z, $air]){
		}
		$pos = $air->getPosition();
		$name = $guard->getName($pos);
		if(!$p->hasPermission("WorldGuardPlugin.permissimon")){
			if($guard->getBlockJoin($pos)){
				if($guaraData->getBuild($name)){
					if(! $guaraData->getMembers($name, $p->getName())){
						$p->sendMessage($this->tag . $this->api->getAPI()->getString("BlockPreak"));
						$ev->cancel();
					}
				}
			}
		}
	}

	public function onExp(EntityPreExplodeEvent $ev){
		$explosion = $ev->getEntity();
		if ($explosion == null){
			return;
		}
		$explosionPosition = $explosion->getPosition();
		$guaraData = GuarddData::getInstance();
		$guard = WorldData::getInstance();
		$x = $explosionPosition->x;
		$y = $explosionPosition->y;
		$z = $explosionPosition->z;
		$explosionRadius = $ev->getRadius();
		for($i = $x - $explosionRadius; $i <= $x + $explosionRadius; $i++){
			for($j = $y - $explosionRadius; $j <= $y + $explosionRadius; $j++){
				for($k = $z - $explosionRadius; $k <= $z + $explosionRadius; $k++){
					$pos = new Position($i, $j, $k, Server::getInstance()->getWorldManager()->getWorldByName($ev->getEntity()->getWorld()->getFolderName()));
					$name = $guard->getName($pos);
					if($guaraData->getTNT($name)){
						if($guard->getBlockJoin($pos)){
							$ev->getEntity()->close();
							$ev->setBlockBreaking(false);
						}
					}
				}
			}
		}
	}
}