<?php

namespace gamegam\HypixelBook\cmd;

use gamegam\HypixelBook\Form\EditForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class BookAdmin extends Command{

	public $api;

	public function __construct($api)
	{
		parent::__construct("setbook", "Book Edit");
		$this->setPermission("HypixelBook.set");
		$this->api = $api;
	}

	public function execute(CommandSender $p, string $commandLabel, array $args):void
	{
		if (! $p instanceof Player){
			$p->sendMessage("Enter it in the in game");
		}else{
			$p->sendForm(new EditForm($this->api));
		}
	}
}