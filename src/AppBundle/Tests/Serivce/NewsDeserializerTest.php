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

	/**
	 * @expectedException \UnexpectedValueException
	 */
	public function testDeserializeUnsupportedDataFormat()
	{
		new NewsDeserializer(SerializerBuilder::create()->build(), 'mp3');
	}

	public function testDeserializeOneFromJson()
	{
		$expectedNewsTitle = 'Zderzyły się trzy auta. Jedna osoba nie żyje, pięć jest rannych';
		$expectedNewsTime = '2016-04-02 14:24';
		$expectedNewsContent = 'Tragiczny wypadek na trasie Bydgoszcz-Stryszek, gdzie zderzyły się trzy samochody.';

		$news = $this->deserializer->deserializeOne(
			$this->prepareSingleJsonNews($expectedNewsTitle, $expectedNewsTime, $expectedNewsContent)
		);

		$this->assertInstanceOf('AppBundle\Entity\News', $news);

		$this->assertEquals($expectedNewsTitle, $news->getTitle());
		$this->assertEquals($expectedNewsTime, $news->getTime()->format('Y-m-d H:i'));
		$this->assertEquals($expectedNewsContent, $news->getContent());
	}

	public function testDeserializeCollectionFromJson()
	{
		$expectedNewsTitle = 'Zderzyły się trzy auta. Jedna osoba nie żyje, pięć jest rannych';
		$expectedNewsTime = '2016-04-02 14:24';
		$expectedNewsContent = 'Tragiczny wypadek na trasie Bydgoszcz-Stryszek, gdzie zderzyły się trzy samochody.';

		$newsCollection = $this->deserializer->deserializeCollection(
			$this->prepareJsonNewsCollection($expectedNewsTitle, $expectedNewsTime, $expectedNewsContent)
		);

		foreach ($newsCollection as $news) {
			$this->assertInstanceOf('AppBundle\Entity\News', $news);

			$this->assertEquals($expectedNewsTitle, $news->getTitle());
			$this->assertEquals($expectedNewsTime, $news->getTime()->format('Y-m-d H:i'));
			$this->assertEquals($expectedNewsContent, $news->getContent());
		}
	}

	protected function setUp()
	{
		$this->deserializer = new NewsDeserializer(SerializerBuilder::create()->build(), 'json');
	}

	/**
	 * @param string $title
	 * @param string $time
	 * @param string $content
	 * @return string
	 */
	private function prepareSingleJsonNews($title, $time, $content)
	{
		return '
			{
		      "title":"'.$title.'",
		      "time":"'.$time.'",
		      "content":"'.$content.'"
		    }
		';
	}

	/**
	 * @param string $title
	 * @param string $time
	 * @param string $content
	 * @return string
	 */
	private function prepareJsonNewsCollection($title, $time, $content)
	{
		return '
		  [
		    '.$this->prepareSingleJsonNews($title, $time, $content).',
		    '.$this->prepareSingleJsonNews($title, $time, $content).'
		  ]
		';
	}
}
