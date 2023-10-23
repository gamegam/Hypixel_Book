<?php

namespace gamegam\HypixelBook\Task;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;
use pocketmine\Server;

class Time extends Task{

    private $p;

    public function __construct(Player $p, $api){
        $this->p = $p;
		$this->api = $api;
    }

    public function onRun():void{
        if ($this->p instanceof Player && $this->p->isOnline()){
            $this->api->Book($this->p);
            if (isset($this->api->db[$this->p->getName()])){
                $this->p->getInventory()->setHeldItemIndex($this->p->getInventory()->getHeldItemIndex());
            }
        }
    }
}
