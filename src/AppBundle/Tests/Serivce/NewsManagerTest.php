<?php

namespace AppBundle\Tests\Service;

use AppBundle\Service\NewsDeserializer;
use AppBundle\Service\NewsImporter;
use AppBundle\Service\NewsManager;
use JMS\Serializer\SerializerBuilder;

class NewsManagerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var NewsManager
	 */
	private $manager;

	/**
	 * @dataProvider provideData
	 * @param int $id
	 * @param string $expectedTitle
	 */
	public function testGetNewsById($id, $expectedTitle)
	{
		$news = $this->manager->getNewsById($id);

		$this->assertInstanceOf('AppBundle\Entity\News', $news);
		$this->assertEquals($expectedTitle, $news->getTitle());
	}

	public function provideData()
	{
		return [
			[0, 'Zderzyły się trzy auta. Jedna osoba nie żyje, pięć jest rannych'],
			[4, '88-latek wpadł w sidła oszustów. Dał im 90 tys. zł na tajną akcję'],
		];
	}

	protected function setUp()
	{
		$this->manager = new NewsManager(
			new NewsImporter(
				new NewsDeserializer(SerializerBuilder::create()->build(), 'json'),
				__DIR__.'/Resources/'
			),
			'news_test.json'
		);
	}
}
