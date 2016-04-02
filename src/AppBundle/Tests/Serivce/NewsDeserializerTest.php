<?php

namespace AppBundle\Tests\Service;

use AppBundle\Service\NewsDeserializer;
use JMS\Serializer\SerializerBuilder;

class NewsDeserializerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var NewsDeserializer
	 */
	private $deserializer;

	public function testDeserializeFromJson()
	{
		$expectedNewsTitle = 'Zderzyły się trzy auta. Jedna osoba nie żyje, pięć jest rannych';
		$expectedNewsTime = '2016-04-02 14:24';
		$expectedNewsContent = 'Tragiczny wypadek na trasie Bydgoszcz-Stryszek, gdzie zderzyły się trzy samochody.';

		$json = '
			{
		      "title":"'.$expectedNewsTitle.'",
		      "time":"'.$expectedNewsTime.'",
		      "content":"'.$expectedNewsContent.'"
		    }
		';

		$news = $this->deserializer->deserializeFromJson($json);

		$this->assertInstanceOf('AppBundle\Entity\News', $news);

		$this->assertEquals($expectedNewsTitle, $news->getTitle());
		$this->assertEquals($expectedNewsTime, $news->getTime()->format('Y-m-d H:i'));
		$this->assertEquals($expectedNewsContent, $news->getContent());
	}

	protected function setUp()
	{
		$this->deserializer = new NewsDeserializer(SerializerBuilder::create()->build());
	}
}
