<?php

namespace gamegam\WorldGuardPlugin;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;

class WorldGuard{

	use SingletonTrait;

	public $api;

	public function __construct(){
		$this->api = Server::getInstance()->getPluginManager()->getPlugin("WorldGuardPlugin");
		self::setInstance($this);
	}

	public function getTag(){
		return $this->api->getConfig()->get("Tag");
	}

	public function setMode(Player $p){
		if (! $this->isMode($p)){
			$this->api->db[$p->getName()]["pos"] = true;
		}else{
			unset($this->api->db[$p->getName()]["pos"]);
		}
	}

	public function isMode(Player $p):bool{
		$bool = false;
		if (isset($this->api->db[$p->getName()]["pos"])){
			$bool = true;
		}
		return $bool;
	}

	public function isPos1(Player $p): bool{
		$bool = false;
		if (isset($this->api->db[$p->getName()]["pos1"])){
			$bool = true;
		}
		return $bool;
	}

	public function cancel(Player $p){
		unset($this->api->db[$p->getName()]);
	}

	public function isModel(Player $p): bool{
		$bool = false;
		if (isset($this->api->db[$p->getName()]["last"])){
			$bool = true;
		}
		return $bool;
	}

	public function setMode1(Player $p, $pos1, $pos2){
		if($this->isPos1($p)){
			$this->api->db[$p->getName()]["last"] = [
				"pos1" => $pos1,
				"pos2" => $pos2
			];
		}
	}

	public function getPlayerData(Player $p):array{
		$data = $this->api->db[$p->getName()] ?? null;
		return $data;
	}

	public function setPos1(Player $p, string $msg){
		if ($this->isMode($p)){
			if (! $this->isPos1($p)){
				$this->api->db[$p->getName()]["pos1"] = $msg;
			}
		}
	}
}