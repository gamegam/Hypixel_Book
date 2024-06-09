<?php

namespace gamegam\HypixelBook\cmd;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class BookCommand extends Command{

	public $api;

	public function __construct($api)
	{
		parent::__construct("rule", "Open the book automatically.");
		$this->setPermission("HypixelBook.Book");
		$this->api = $api;
	}

	public function execute(CommandSender $p, string $commandLabel, array $args):void
	{
		if (! $p instanceof Player){
			$p->sendMessage("Enter it in the in game");
		}else{
			$this->api->Event($p);
		}
	}
}