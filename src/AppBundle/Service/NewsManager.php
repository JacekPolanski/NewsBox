<?php

namespace AppBundle\Service;

class NewsManager
{
	/**
	 * @var News[]
	 */
	private $newsCollection;

	/**
	 * @param NewsImporter $importer
	 * @param $fileName
	 */
	public function __construct(NewsImporter $importer, $fileName)
	{
		$this->newsCollection = $importer->importFromJsonFile($fileName);
	}

	/**
	 * @param $id
	 * @return \AppBundle\Entity\News|null
	 */
	public function findById($id)
	{
		foreach ($this->newsCollection as $news) {
			if ((int) $id === $news->getId()) {
				return $news;
			}
		}

		return null;
	}
}
