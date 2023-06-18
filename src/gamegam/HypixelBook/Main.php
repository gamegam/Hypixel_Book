<?php

namespace gamegam\HypixelBook;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use gamegam\HypixelBook\Book\API;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use gamegam\HypixelBook\Task\Time;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener{

    public static $instance = null;

    public Config $data;

    public $db;

    public Config $config;

    public $hand;

    public function onEnable():void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
        $this->config = (new Config($this->getDataFolder() . "config.yml", Config::YAML));
        $this->data = new Config($this->getDataFolder(). "Data.yml",Config::YAML);
        $this->db = $this->data->getAll();
    }

    public function onLoad(): void{
        if (self::$instance == null)
        self::$instance = $this;
    }

    public static function getInstance(){
        return static::$instance;
    }

    public function getAPI(Player $p):API{
        $new = new API($p);
        return $new;
    }

    public function Book(Player $p){
        $name = $p->getName();
        $item = VanillaItems::WRITTEN_BOOK();
        if (isset($this->db["open"][$name])){
        $time = microtime(true) - $this->db["open"][$name];
		$sec = round($time, 2);
		if ($sec > 0.1){
            $this->getAPI($p)->open($item);
            $p->getInventory()->setItemInHand($this->hand);
            unset($this->db["open"][$name], $this->db["Item"][$name], $this->db[$p->getName()]);
            $this->db["default"][$name] = true;
            }
        }
    }

    public function open(Player $p){
        $item = VanillaItems::WRITTEN_BOOK();
        $name = $p->getName();
        $this->db["open"][$name] = microtime(true);
	    $p->getInventory()->setHeldItemIndex($this->config->get("slot"));
        $name = str_replace('{name}', $p->getName(), $this->config->get("author"));
        $item->setTitle($this->config->get("Title"));
        $page = $this->getConfig()->get("page");
        $item->setAuthor($name);
        foreach ($page as $int => $page) {
            $pageS = str_replace('{name}', $p->getName(), $page);
            $item->setPageText($int, $pageS);
        }
        $p->getInventory()->setItem($this->config->get("slot"), $item);
        $this->Book($p);
    }

    public function Join(PlayerJoinEvent $ev){
    $p = $ev->getPlayer();
    $name = $p->getName();
    $this->hand = $p->getInventory()->getItemInHand();
    $item = VanillaItems::WRITTEN_BOOK();
    unset($this->db["open"][$name], $this->db["default"][$name]);
	$p->getInventory()->setItem(8, $item);	
	$this->db[$name] = true;
    $this->getScheduler()->scheduleRepeatingTask(new Time($p), 0);
    $this->open($p);
    }
}
