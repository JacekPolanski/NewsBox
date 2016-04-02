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
		$data = @file_get_contents($this->importDir.$filename);

		if (!$data) {
			throw new \RuntimeException(sprintf('Cant read %s file', $filename));
		}

		return $this->deserializer->deserializeCollection(file_get_contents($this->importDir.$filename));
	}
}
