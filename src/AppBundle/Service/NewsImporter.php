<?php

namespace AppBundle\Service;

class NewsImporter
{
	/**
	 * @var NewsDeserializer
	 */
	private $deserializer;

	/**
	 * @var string
	 */
	private $importDir;

	/**
	 * @param NewsDeserializer $deserializer
	 * @param string $importDir
	 */
	public function __construct(NewsDeserializer $deserializer, $importDir)
	{
		$this->deserializer = $deserializer;
		$this->importDir = $importDir;
	}

	/**
	 * @param $filename
	 * @return \AppBundle\Entity\News[]
	 */
	public function importFromJsonFile($filename)
	{
		return $this->deserializer->deserializeCollection(file_get_contents($this->importDir.$filename));
	}
}
