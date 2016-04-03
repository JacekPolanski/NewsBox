<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\File;

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
		$file = new File($this->importDir.$filename);

		$this->validateJsonFile($file);

		$data = @file_get_contents($file->getPathname());

		if (!$data) {
			throw new \RuntimeException(sprintf('Cant read %s file', $file->getFilename()));
		}

		return $this->deserializer->deserializeCollection($data);
	}

	/**
	 * @param File $file
	 * @throws \RuntimeException when validation fails
	 */
	private function validateJsonFile(File $file)
	{
		if ('json' !== $file->getExtension()) {
			throw new \RuntimeException(sprintf('%s is not a Json file!', $file->getFilename()));
		}
	}
}
