<?php

namespace gamegam\HypixelBook\Form;

use pocketmine\form\Form;
use pocketmine\player\Player;

class DeleteForm implements Form{

	public $api;

	public function __construct($api){
		$this->api = $api;
	}

	public function jsonSerialize():array
	{
		return [
			"type" => "modal",
			"title" => "",
			"content" => "Are you going to remove the page?",
			"button1" => "Yes",
			"button2" => "No"
		];
	}

	public function handleResponse(Player $p, $data): void
	{
		if ($data === null){
			return;
		}
		if ($data == 0){
		}else{
			if($data == 1){
				$array = $this->api->config->get('page');
				$count = 0;
				foreach ($array as $page){
					$count ++;
				}
				if ($count < 1){
					$p->sendMessage("You can't remove any more");
					return;
				}
				if (!empty($array)){
					$removedItem = array_pop($array);
					$this->api->config->set("page", $array);
					$this->api->config->save();
					$p->sendMessage("Page Delete! $removedItem removed.(Apply at reboot)");
				}
			}
		}
	}
}
