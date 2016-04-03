<?php

namespace AppBundle\Tests\Service;

use AppBundle\Entity\News;
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

    /**
     * @expectedException \RuntimeException
     */
    public function testDeserializeJsonWithSyntaxError()
    {
        $json = '
          "title":"cos",
          "time":"xxxxxx",
          "content":"asd"
        ';

        $this->deserializer->deserializeOne($json);
    }

    /**
     * @dataProvider provideDataWithWrongValues
     * @expectedException \RuntimeException
     * @param string $expectedTitle
     * @param string $expectedTime
     * @param string $expectedContent
     */
    public function testDeserializeJsonWithWrongValues($expectedTitle, $expectedTime, $expectedContent)
    {
        $this->deserializer->deserializeOne(
            $this->prepareSingleJsonNews($expectedTitle, $expectedTime, $expectedContent)
        );
    }

    /**
     * @dataProvider provideDataForDeserializeTest
     * @param string $expectedTitle
     * @param string $expectedTime
     * @param string $expectedContent
     */
    public function testDeserializeOneFromJson($expectedTitle, $expectedTime, $expectedContent)
    {
        $news = $this->deserializer->deserializeOne(
            $this->prepareSingleJsonNews($expectedTitle, $expectedTime, $expectedContent)
        );

        $this->assertInstanceOf('AppBundle\Entity\News', $news);
        $this->assertNewsEquals($expectedTitle, $expectedTime, $expectedContent, $news);
    }

    /**
     * @dataProvider provideDataForDeserializeTest
     * @param string $expectedTitle
     * @param string $expectedTime
     * @param string $expectedContent
     */
    public function testDeserializeCollectionFromJson($expectedTitle, $expectedTime, $expectedContent)
    {
        $newsCollection = $this->deserializer->deserializeCollection(
            $this->prepareJsonNewsCollection($expectedTitle, $expectedTime, $expectedContent)
        );

        foreach ($newsCollection as $news) {
            $this->assertInstanceOf('AppBundle\Entity\News', $news);
            $this->assertNewsEquals($expectedTitle, $expectedTime, $expectedContent, $news);
        }
    }

    /**
     * @return array
     */
    public function provideDataForDeserializeTest()
    {
        return [
            [
                'Zderzyły się trzy auta. Jedna osoba nie żyje, pięć jest rannych',
                '2016-04-02 14:24',
                'Tragiczny wypadek na trasie Bydgoszcz-Stryszek, gdzie zderzyły się trzy samochody.',
            ],
        ];
    }

    /**
     * @return array
     */
    public function provideDataWithWrongValues()
    {
        return [
            [
                'Zderzyły się trzy auta. Jedna osoba nie żyje, pięć jest rannych',
                '2016',
                'Tragiczny wypadek na trasie Bydgoszcz-Stryszek, gdzie zderzyły się trzy samochody.',
            ],
        ];
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
              "title":"' . $title . '",
              "time":"' . $time . '",
              "content":"' . $content . '"
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
            ' . $this->prepareSingleJsonNews($title, $time, $content) . ',
            ' . $this->prepareSingleJsonNews($title, $time, $content) . '
          ]
        ';
    }

    /**
     * @param string $expectedTitle
     * @param string $expectedTime
     * @param string $expectedContent
     * @param News $news
     */
    private function assertNewsEquals($expectedTitle, $expectedTime, $expectedContent, News $news)
    {
        $this->assertEquals($expectedTitle, $news->getTitle());
        $this->assertEquals($expectedTime, $news->getTime()->format('Y-m-d H:i'));
        $this->assertEquals($expectedContent, $news->getContent());
    }
}
