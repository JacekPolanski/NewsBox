<?php

namespace AppBundle\Tests\Service;

use AppBundle\Service\NewsDeserializer;
use AppBundle\Service\NewsImporter;
use AppBundle\Service\NewsRepository;
use JMS\Serializer\SerializerBuilder;

/**
 * Class NewsRepositoryTest
 * @package AppBundle\Tests\Service
 */
class NewsRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NewsRepository
     */
    private $repository;

    /**
     * @dataProvider provideData
     * @param int $id
     * @param string $expectedTitle
     */
    public function testGetNewsById($id, $expectedTitle)
    {
        $news = $this->repository->findById($id);

        $this->assertInstanceOf('AppBundle\Entity\News', $news);
        $this->assertEquals($expectedTitle, $news->getTitle());
    }

    /**
     * @return array
     */
    public function provideData()
    {
        return [
            [0, 'Zderzyły się trzy auta. Jedna osoba nie żyje, pięć jest rannych'],
            [4, '88-latek wpadł w sidła oszustów. Dał im 90 tys. zł na tajną akcję'],
        ];
    }

    protected function setUp()
    {
        $this->repository = new NewsRepository(
            new NewsImporter(
                new NewsDeserializer(SerializerBuilder::create()->build(), 'json'),
                __DIR__ . '/Resources/'
            ),
            'news_test.json'
        );
    }
}
