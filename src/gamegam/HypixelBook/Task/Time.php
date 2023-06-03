<?php

namespace gamegam\HypixelBook\Task;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;
use pocketmine\Server;

class Time extends Task{

    private $p;

    public function __construct(Player $p){
        $this->p = $p;
    }

    public function onRun():void{
        $api = Server::getInstance()->getPluginManager()->getPlugin("HypixelBook");
        $name = $this->p->getName();
        if ($this->p instanceof Player && $this->p->isOnline()){
            $api->Book($this->p);
            if (isset($api->db[$this->p->getName()])){
                $this->p->getInventory()->setHeldItemIndex($api->config->get("slot"));
            }
        }
    }
}
