<?php

namespace gamegam\HypixelBook\Form;

use pocketmine\form\Form;
use pocketmine\player\Player;

class addPage implements Form{

	public $api;

	public function __construct($api)
	{
		$this->api = $api;
	}

	public function jsonSerialize():array
	{
		return [
			"type" => "custom_form",
			"title" => "",
			"content" => [[
				"type" => "input",
				"text" => "Please enter the contents of the page"
			]
			]
		];
	}

	public function handleResponse(Player $p, $data): void
	{
		if (!isset($data[0])){
			return;
		}
		$array = [];
		$config = $this->api->config->get("page");
		$count = 0;//페이지
		foreach ($config as $page => $contents){
			$array[] = $contents;
		}
		$array[] .= $data[0];
		$this->api->config->set("page", $array);
		$this->api->config->save();
		$p->sendMessage("Added Page(Apply at reboot)");
	}
}