<?php

namespace gamegam\WorldGuardPlugin;

use gamegam\WorldGuardPlugin\command\WorldGuardCommand;
use gamegam\WorldGuardPlugin\EvnetListener\Blocks;
use gamegam\WorldGuardPlugin\EvnetListener\WorldGuardEvent\BlocGuard;
use gamegam\WorldGuardPlugin\EvnetListener\WorldGuardEvent\Damage;
use gamegam\WorldGuardPlugin\EvnetListener\WorldGuardEvent\Entity;
use gamegam\WorldGuardPlugin\EvnetListener\WorldGuardEvent\Player;
use gamegam\WorldGuardPlugin\Language\ABC;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Filesystem;
use Symfony\Component\Filesystem\Path;
use pocketmine\event\plyaer\PlayerJoinEvent;

class Main extends PluginBase implements Listener{

	public array $db = [];
	public $abc;

	public function onEnable() : void{
		$path = Path::join($this->getDataFolder(), "worldGuard.json");
		if(file_exists($path)){
			$this->db = json_decode(Filesystem::fileGetContents($path), true);
		}

		$this->abc = new ABC($this);
		$this->abc->Load($this->getConfig()->get("language"));

		$this->getServer()->getCommandMap()->registerAll($this->getName(), [
			new WorldGuardCommand($this)
		]);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->registerEvnet([
			$this,
			new Blocks($this),
			new BlocGuard($this),
			new Damage($this),
			new Player($this),
			new Entity($this)
			]
		);
	}

	public function registerEvnet(array $s){
		foreach($s as $list){
			$this->getServer()->getPluginManager()->registerEvents($list, $this);
		}
	}

	public function getAPI(): ABC{
		return $this->abc;
	}

	public function save():void{
		$this->onDisable();
	}
}