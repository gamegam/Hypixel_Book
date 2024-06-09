<?php

namespace gamegam\WorldGuardPlugin\Language;

use gamegam\WorldGuardPlugin\Main;

class ABC{

	public $api;

	public function __construct(Main $api){
		$this->api = $api;
	}

	public $def = "en-US";
	private $list = [
		"en-US",
		"ko-KR"
	];

	public $language;
	public $translations;

	public function Load(string $string): void {
		$api = $this->api;
		$folder = $api->getDataFolder() . "Language";
		@mkdir($folder);
		foreach ($this->list as $guard) {
			$resourcePath = "Language" . DIRECTORY_SEPARATOR . $guard . ".yml";
			$api->saveResource($resourcePath, true);
		}
		$filePath = $folder . DIRECTORY_SEPARATOR . $string . ".yml";
		if (file_exists($filePath)){
			$this->language = $string;
			$this->translations = yaml_parse_file($filePath);
		}
	}


	public function getString(string $translation, array $variables = []): string{
		$data = $this->translations[$translation] ?? null;
		if ($data == null){
			return " not found: ". $translation;
		}else{
			return $data;
		}
	}

	public function getArray(string $translation): ?array
{
	return $this->translations[$translation] ?? null;
}

	public function getLanguage(): string
	{
		return $this->language;
	}

	private function translate(string $translation, array $variables = []): string
	{
		return str_replace(array_keys($variables), array_values($variables),$this->translations[$translation]);
	}
}