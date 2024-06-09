<?php

namespace gamegam\HypixelBook\Form;

use pocketmine\form\Form;
use pocketmine\player\Player;

class EditBook implements Form{

	public $api;

	public function __construct($api)
	{
		$this->api = $api;
	}

	public function jsonSerialize():array
	{
		$api = $this->api;
		$this->array = [];
		$b = [];
		foreach ($api->config->get("page") as $int => $page){
			$b[] = $page;
		}
		$this->array = $b;
		return [
			"type" => "custom_form",
			"title" => "",
			"content" => [[
				"type" => "dropdown",
				"text" => "Tags",
				"options" => $this->array
				],
				[
				"type" => "input",
				"text" => "Select a tag above to edit its content"
			]
			]
		];
	}

	public function handleResponse(Player $p, $data): void
	{
		if (!isset($data[0])) {
			return;
		}
		$config = $this->api->config->get("page");
		$index = $data[0];
		if (array_key_exists($index, $config)) {
			$config[$index] = $data[1];
			$this->api->config->set("page", $config);
			$this->api->config->save();
			$p->sendMessage("Contents have been changed.");
		} else {
			$p->sendMessage("§cDoes not exist");
		}
	}
}