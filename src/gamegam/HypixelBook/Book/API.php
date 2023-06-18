<?php

namespace gamegam\HypixelBook\Book;

use pocketmine\player\Player;
use pocketmine\item\Item;
use pocketmine\item\WritableBookBase;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\protocol\types\inventory\{ItemStackWrapper, UseItemTransactionData};
use pocketmine\Server;

class API{

    public Player $p;

    public function __construct(Player $p){
        $this->p = $p;
    }

    /**
     * Bokk open
     */
    public function open(Item $item){
        $api = Server::getInstance()->getPluginManager()->getPlugin("HypixelBook");
        $p = $this->p;
        $name = strtolower($p->getName());
        if ($item instanceof WritableBookBase){
            $hand = $p->getInventory()->getHeldItemIndex();
            $items = $p->getInventory()->getItem($hand);
            $p->getInventory()->setItem($hand, $item);
            $p->getInventory()->setHeldItemIndex($hand);
            $p->getNetworkSession()->sendDataPacket(InventoryTransactionPacket::create(0,[], UseItemTransactionData::new([], UseItemTransactionData::ACTION_CLICK_AIR,new BlockPosition(0, 0, 0),255, $hand,ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($item)), $p->getPosition(),new Vector3(0, 0, 0), 0)));
            $p->getInventory()->setItem($api->config->get("slot"), $items);
            $p->getInventory()->setHeldItemIndex($hand);
        }
    }
}
