<?php

namespace gamegam\WorldGuardPlugin\Data;


use gamegam\WorldGuardPlugin\WorldData;
use gamegam\WorldGuardPlugin\WorldGuard;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;

class GuarddData{

	use SingletonTrait;

	public $api, $worldguard, $data;

	public function __construct(){
		self::setInstance($this);
		$this->api = Server::getInstance()->getPluginManager()->getPlugin("WorldGuardPlugin");
		$this->worldguard = WorldGuard::getInstance();
		$this->data = WorldData::getInstance();
	}

	public function getChat(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["chat"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getMobSpawn(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["mob-spawn"])){
				$bool = true;
			}
		}
		return $bool;
	}

	/**
	 * If you detect a build in the area
	 */

	public function getBuild(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["build"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getInteract(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["use"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getMembers(string $name, $p): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if(isset($this->api->db["name"][$name]["member"][strtolower($p)])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getTNT(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["tnt"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getinvincible(string $name){
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["invincible"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getLave(string $name):bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["lava-flow"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getWater(string $name):bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["water"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getTNTDamage(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["tnt-damage"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getPVP(string $name){
		$bool = false;
		if ($this->data->isName($name)){
			if (isset($this->api->db["name"][$name]["flag"]["pvp"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getMobDamage(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if(isset($this->api->db["name"][$name]["flag"]["mob-damage"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getMobPVP(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if(isset($this->api->db["name"][$name]["flag"]["mob-pvp"])){
				$bool = true;
			}
		}
		return $bool;
	}

	public function getfire(string $name): bool{
		$bool = false;
		if ($this->data->isName($name)){
			if(isset($this->api->db["name"][$name]["flag"]["fire"])){
				$bool = true;
			}
		}
		return $bool;
	}
}