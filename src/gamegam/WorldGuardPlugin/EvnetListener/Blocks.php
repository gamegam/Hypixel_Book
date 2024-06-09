<?php

namespace gamegam\WorldGuardPlugin\EvnetListener;

use gamegam\WorldGuardPlugin\Main;
use gamegam\WorldGuardPlugin\WorldGuard;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Server;

class Blocks implements Listener{

	public $api, $worldguard;
	public function __construct(Main $api){
		$this->api = $api;
		$this->worldguard = WorldGuard::getInstance();
	}

	public function onInteract(PlayerInteractEvent $ev){
		$p = $ev->getPlayer();
		$api = $this->worldguard;
		$mode = $api->isMode($p);
		$block = $ev->getBlock();
		$pos = $block->getPosition();
		$x = $pos->getX();
		$y = $pos->getY();
		$z = $pos->getZ();
		$configx = str_replace("(x)", $x, $this->api->getAPI()->getString("pos1"));
		$configy = str_replace("(y)", $y, $configx);
		$configz = str_replace("(z)", $z, $configy);
		$all = $x.":".$y.":".$z.":".$p->getWorld()->getFolderName();
		if ($mode && ! $api->isPos1($p)){
			$p->sendMessage($configz);
			$api->setPos1($p, $all);
			$ev->cancel();
		}
	}

	public function onBlockBreak(BlockBreakEvent $ev){
		$p = $ev->getPlayer();
		$api = $this->worldguard;
		$mode = $api->isMode($p);
		$block = $ev->getBlock();
		$pos = $block->getPosition();
		$x = $pos->getX();
		$y = $pos->getY();
		$z = $pos->getZ();
		$configx = str_replace("(x)", $x, $this->api->getAPI()->getString("pos2"));
		$configy = str_replace("(y)", $y, $configx);
		$configz = str_replace("(z)", $z, $configy);
		$all = $x.":".$y.":".$z.":".$p->getWorld()->getFolderName();
		if ($mode){
			if ($api->isPos1($p)){
				$data = $api->getPlayerData($p) ?? null;
				if ($data == null){
					$this->api->getAPI()->getString("null");
				}else{
					$ex = explode(":", $data["pos1"]);
					$world = $ex[3] ?? "";
					if ($world !== $p->getWorld()->getFolderName()){
						$a = $this->api->getAPI()->getString("createError1");
						$error = str_replace("(world)", $world, $a);
						$p->sendMessage($error);
						$ev->cancel();
						return;
					}
					$p->sendMessage($configz);
					$this->worldguard->setMode1($p, $data["pos1"], $all);
					$ev->cancel();
				}
			}
		}
	}
}