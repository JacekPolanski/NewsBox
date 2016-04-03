<?php

namespace AppBundle\Tests\Service;

use AppBundle\Service\NewsDeserializer;
use AppBundle\Service\NewsImporter;
use JMS\Serializer\SerializerBuilder;

class NewsImporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NewsImporter
     */
    private $importer;

    public function testImportFromJsonFile()
    {
        $newsCollection = $this->importer->importFromJsonFile('news_test.json');

        foreach ($newsCollection as $news) {
            $this->assertInstanceOf('AppBundle\Entity\News', $news);
        }
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testImportFromNotExistingFile()
    {
        $this->importer->importFromJsonFile('xxxx.json');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testImportNotJsonFile()
    {
        $this->importer->importFromJsonFile('news_test.txt');
    }

    protected function setUp()
    {
        $this->importer = new NewsImporter(
            new NewsDeserializer(SerializerBuilder::create()->build(), 'json'),
            __DIR__ . '/Resources/'
        );
    }
}
