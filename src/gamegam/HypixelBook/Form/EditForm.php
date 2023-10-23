<?php

namespace gamegam\HypixelBook\Form;

use pocketmine\form\Form;
use pocketmine\player\Player;

class EditForm implements Form{

	public $api;

	public function __construct($api)
	{
		$this->api = $api;
	}

	public function jsonSerialize():array
	{
		return [
			"type" => "form",
			"title" => "",
			"content" => "",
			"buttons" => [[
				"text" => "§lAddPage\nPage Add"
			],
				[
					"text" => "§lDelete Page\nPage to delete"
				],
				[
					"text" => "§lEdit Book\nModify content on that page"
				]
			]
		];
	}

	public function handleResponse(Player $p, $data): void
	{
		if ($data === null){
			return;
		}
		$form = match($data){
			0 => new addPage($this->api),
			1 => new DeleteForm($this->api),
			2 => new EditBook($this->api)
		};
		$p->sendForm($form);
	}
}