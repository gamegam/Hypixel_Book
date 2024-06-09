<?php

namespace gamegam\WorldGuardPlugin\EvnetListener\WorldGuardEvent;

use gamegam\WorldGuardPlugin\Data\GuarddData;
use gamegam\WorldGuardPlugin\Main;
use gamegam\WorldGuardPlugin\WorldData;
use gamegam\WorldGuardPlugin\WorldGuard;
use pocketmine\block\ItemFrame;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;

class Player implements Listener{

	public $tag, $api;

	public function __construct(Main $api){
		$this->tag = WorldGuard::getInstance()->getTag();
		$this->api = $api;
	}

	public function onChat(PlayerChatEvent $ev){
		$p = $ev->getPlayer();
		$pos = $p->getPosition();
		$guard = WorldData::getInstance();
		$worlddata = GuarddData::getInstance();
		$name = $guard->getName($pos);
		if ($guard->getBlockJoin($pos)){
			if ($worlddata->getChat($name)){
				if(! $p->hasPermission("WorldGuardPlugin.permissimon")){
					$p->sendMessage($this->tag. $this->api->getAPI()->getString("chat"));
					$ev->cancel();
				}
			}
		}
	}

	public function onInteractEvent(PlayerInteractEvent $ev){
		$p = $ev->getPlayer();
		$block = $ev->getBlock();
		$data = WorldData::getInstance();
		$d = GuarddData::getInstance();
		$guard = WorldData::getInstance();
		$pos = $p->getPosition();
		$name = $data->getName($pos);
		$ac = $ev->getAction();
		if(! $p->hasPermission("WorldGuardPlugin.permissimon")){
			if($guard->getBlockJoin($pos)){
				if ($d->getInteract($name)){
					if ($ac == 0 && ! $block instanceof ItemFrame){
						return true;
					}
					if(! $d->getMembers($name, $p->getName())){
						$p->sendMessage($this->tag. $this->api->getAPI()->getString("Use"));;
						$ev->cancel();
					}
				}
			}
		}
	}

	public function onMove(PlayerMoveEvent $ev){
		$p = $ev->getPlayer();
		$pos = $p->getPosition();
		$data = WorldData::getInstance();
		$d = GuarddData::getInstance();
		$guard = WorldData::getInstance();
		$name = $data->getName($pos);
		if($guard->getBlockJoin($pos)){
			if ($d->getfire($name)){
				if ($d->getfire($name)){
					$p->extinguish();
				}
			}
		}
	}
}