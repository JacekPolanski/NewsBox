<?php

namespace AppBundle\Service;

use AppBundle\Entity\News;

/**
 * Class NewsRepository
 * @package AppBundle\Service
 */
class NewsRepository
{
    /**
     * @var News[]
     */
    private $newsCollection;

    /**
     * @param NewsImporter $importer
     * @param string       $fileName
     */
    public function __construct(NewsImporter $importer, $fileName)
    {
        $this->newsCollection = $importer->importFromJsonFile($fileName);
    }

    /**
     * @param int $id
     * @return News|null
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

    /**
     * @return News[]
     */
    public function findAll()
    {
        return $this->newsCollection;
    }
}
